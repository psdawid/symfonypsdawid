<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Messenger\Command;

use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\EventListener\StopWorkerOnFailureLimitListener;
use Symfony\Component\Messenger\EventListener\StopWorkerOnMemoryLimitListener;
use Symfony\Component\Messenger\EventListener\StopWorkerOnMessageLimitListener;
use Symfony\Component\Messenger\EventListener\StopWorkerOnTimeLimitListener;
use Symfony\Component\Messenger\RoutableMessageBus;
use Symfony\Component\Messenger\Worker;

/**
 * @author Samuel Roze <samuel.roze@gmail.com>
 */
class ConsumeMessagesCommand extends Command
{
    protected static $defaultName = 'messenger:consume';

    private $routableBus;
    private $receiverLocator;
    private $logger;
    private $receiverNames;
    private $eventDispatcher;

    public function __construct(RoutableMessageBus $routableBus, ContainerInterface $receiverLocator, EventDispatcherInterface $eventDispatcher, LoggerInterface $logger = null, array $receiverNames = [])
    {
        $this->routableBus = $routableBus;
        $this->receiverLocator = $receiverLocator;
        $this->logger = $logger;
        $this->receiverNames = $receiverNames;
        $this->eventDispatcher = $eventDispatcher;

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $defaultReceiverName = 1 === \count($this->receiverNames) ? current($this->receiverNames) : null;

        $this
            ->setDefinition([
                new InputArgument('receivers', InputArgument::IS_ARRAY, 'Names of the receivers/transports to consume in order of priority', $defaultReceiverName ? [$defaultReceiverName] : []),
                new InputOption('limit', 'l', InputOption::VALUE_REQUIRED, 'Limit the number of received messages'),
                new InputOption('failure-limit', 'f', InputOption::VALUE_REQUIRED, 'The number of failed messages the worker can consume'),
                new InputOption('memory-limit', 'm', InputOption::VALUE_REQUIRED, 'The memory limit the worker can consume'),
                new InputOption('time-limit', 't', InputOption::VALUE_REQUIRED, 'The time limit in seconds the worker can run'),
                new InputOption('sleep', null, InputOption::VALUE_REQUIRED, 'Seconds to sleep before asking for new messages after no messages were found', 1),
                new InputOption('bus', 'b', InputOption::VALUE_REQUIRED, 'Name of the bus to which received messages should be dispatched (if not passed, bus is determined automatically)'),
            ])
            ->setDescription('Consumes messages')
            ->setHelp(<<<'EOF'
The <info>%command.name%</info> command consumes messages and dispatches them to the message bus.

    <info>php %command.full_name% <receiver-name></info>

To receive from multiple transports, pass each name:

    <info>php %command.full_name% receiver1 receiver2</info>

Use the --limit option to limit the number of messages received:

    <info>php %command.full_name% <receiver-name> --limit=10</info>

Use the --failure-limit option to stop the worker when the given number of failed messages is reached:

    <info>php %command.full_name% <receiver-name> --failure-limit=2</info>

Use the --memory-limit option to stop the worker if it exceeds a given memory usage limit. You can use shorthand byte values [K, M or G]:

    <info>php %command.full_name% <receiver-name> --memory-limit=128M</info>

Use the --time-limit option to stop the worker when the given time limit (in seconds) is reached:

    <info>php %command.full_name% <receiver-name> --time-limit=3600</info>

Use the --bus option to specify the message bus to dispatch received messages
to instead of trying to determine it automatically. This is required if the
messages didn't originate from Messenger:

    <info>php %command.full_name% <receiver-name> --bus=event_bus</info>
EOF
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output instanceof ConsoleOutputInterface ? $output->getErrorOutput() : $output);

        if ($this->receiverNames && 0 === \count($input->getArgument('receivers'))) {
            $io->block('Which transports/receivers do you want to consume?', null, 'fg=white;bg=blue', ' ', true);

            $io->writeln('Choose which receivers you want to consume messages from in order of priority.');
            if (\count($this->receiverNames) > 1) {
                $io->writeln(sprintf('Hint: to consume from multiple, use a list of their names, e.g. <comment>%s</comment>', implode(', ', $this->receiverNames)));
            }

            $question = new ChoiceQuestion('Select receivers to consume:', $this->receiverNames, 0);
            $question->setMultiselect(true);

            $input->setArgument('receivers', $io->askQuestion($question));
        }

        if (0 === \count($input->getArgument('receivers'))) {
            throw new RuntimeException('Please pass at least one receiver.');
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $receivers = [];
        foreach ($receiverNames = $input->getArgument('receivers') as $receiverName) {
            if (!$this->receiverLocator->has($receiverName)) {
                $message = sprintf('The receiver "%s" does not exist.', $receiverName);
                if ($this->receiverNames) {
                    $message .= sprintf(' Valid receivers are: %s.', implode(', ', $this->receiverNames));
                }

                throw new RuntimeException($message);
            }

            $receivers[$receiverName] = $this->receiverLocator->get($receiverName);
        }

        $stopsWhen = [];
        if ($limit = $input->getOption('limit')) {
            $stopsWhen[] = "processed {$limit} messages";
            $this->eventDispatcher->addSubscriber(new StopWorkerOnMessageLimitListener($limit, $this->logger));
        }

        if ($failureLimit = $input->getOption('failure-limit')) {
            $stopsWhen[] = "reached {$failureLimit} failed messages";
            $this->eventDispatcher->addSubscriber(new StopWorkerOnFailureLimitListener($failureLimit, $this->logger));
        }

        if ($memoryLimit = $input->getOption('memory-limit')) {
            $stopsWhen[] = "exceeded {$memoryLimit} of memory";
            $this->eventDispatcher->addSubscriber(new StopWorkerOnMemoryLimitListener($this->convertToBytes($memoryLimit), $this->logger));
        }

        if ($timeLimit = $input->getOption('time-limit')) {
            $stopsWhen[] = "been running for {$timeLimit}s";
            $this->eventDispatcher->addSubscriber(new StopWorkerOnTimeLimitListener($timeLimit, $this->logger));
        }

        $stopsWhen[] = 'received a stop signal via the messenger:stop-workers command';

        $io = new SymfonyStyle($input, $output instanceof ConsoleOutputInterface ? $output->getErrorOutput() : $output);
        $io->success(sprintf('Consuming messages from transport%s "%s".', \count($receivers) > 0 ? 's' : '', implode(', ', $receiverNames)));

        if ($stopsWhen) {
            $last = array_pop($stopsWhen);
            $stopsWhen = ($stopsWhen ? implode(', ', $stopsWhen).' or ' : '').$last;
            $io->comment("The worker will automatically exit once it has {$stopsWhen}.");
        }

        $io->comment('Quit the worker with CONTROL-C.');

        if (OutputInterface::VERBOSITY_VERBOSE > $output->getVerbosity()) {
            $io->comment('Re-run the command with a -vv option to see logs about consumed messages.');
        }

        $bus = $input->getOption('bus') ? $this->routableBus->getMessageBus($input->getOption('bus')) : $this->routableBus;

        $worker = new Worker($receivers, $bus, $this->eventDispatcher, $this->logger);
        $worker->run([
            'sleep' => $input->getOption('sleep') * 1000000,
        ]);

        return 0;
    }

    private function convertToBytes(string $memoryLimit): int
    {
        $memoryLimit = strtolower($memoryLimit);
        $max = ltrim($memoryLimit, '+');
        if (0 === strpos($max, '0x')) {
            $max = \intval($max, 16);
        } elseif (0 === strpos($max, '0')) {
            $max = \intval($max, 8);
        } else {
            $max = (int) $max;
        }

        switch (substr(rtrim($memoryLimit, 'b'), -1)) {
            case 't': $max *= 1024;
            // no break
            case 'g': $max *= 1024;
            // no break
            case 'm': $max *= 1024;
            // no break
            case 'k': $max *= 1024;
        }

        return $max;
    }
}