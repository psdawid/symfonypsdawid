CHANGELOG for 6.1.x
===================

This changelog references the relevant changes (bug and security fixes) done
in 6.1 minor versions.

To get the diff for a specific change, go to https://github.com/symfony/symfony/commit/XXX where XXX is the change hash
To get the diff between two versions, go to https://github.com/symfony/symfony/compare/v6.1.0...v6.1.1

* 6.1.0-BETA2 (2022-04-27)

 * feature #45282 [Serializer] Support canners in object normalizer (rmikalkenas)
 * feature #46157 [Routing] Remove variadic constructor signature (wouterj)
 * bug #46154 [Mailer] Restore X-Transport after failure (zenas1210)
 * bug #46178 [DependencyInjection] Properly declare #[When] as allowed on functions (nicolas-grekas)
 * bug #46171 [VarDumper] Fix dumping floats on PHP8 (nicolas-grekas)
 * bug #46170 Fix dumping enums on PHP 8.2 (nicolas-grekas)
 * bug #46143 [Cache] Prevent fatal errors on php 8 when running concurrently with TagAwareAdapter v6.1 (sbelyshkin)
 * bug #45896 [Cache] Optimize caching of tags (sbelyshkin)
 * bug #46149 Modify processing of uploaded files to be compatible with PHP 8.1 (p-golovin)
 * feature #46112 [DependencyInjection] Rename `#[InnerService]` to `#[MapDecorated]` (chalasr)
 * bug #46125 [FrameworkBundle] Always add CacheCollectorPass (fancyweb)
 * feature #45989 [FrameworkBundle] deprecate not setting http_method_override (Tobion)
 * feature #46042 [Routing] Add params variable to condition expression (HypeMC)
 * feature #46115 [FrameworkBundle] Add support for route attributes in kernel controller methods (dunglas)
 * bug #46121 Fix "Notice: Undefined index: headers" in messenger with Oracle (rjd22)
 * feature #45834 [DependencyInjection] add AsDecorator class attribute and InnerService parameter attribute (Jean-Beru)
 * bug #46106 [String] Fix ansi escape sequences regex (fancyweb)
 * feature #46056 [PropertyInfo] Add support for promoted properties in PhpStanExtractor (simPod)
 * feature #46047 [Notifier] smsapi - send messages in test mode (Patryk Kozłowski)
 * bug #46097 [Routing] fix router base url when default uri has trailing slash (Tobion)
 * feature #46052 [TwigBundle] Deprecate option "autoescape", use "autoescape_service[_method]" instead (nicolas-grekas)
 * bug #46054 [SecurityBundle] Use config's secret in remember-me signatures (jderusse)
 * feature #45528 [Routing] Add Requirement, a collection of universal regular-expressions constants to use as route parameter requirements (fancyweb)
 * bug #46051 Don't replace symfony/security-guard (derrabus)

* 6.1.0-BETA1 (2022-04-15)

 * feature #44798 [FrameworkBundle] Integrate the HtmlSanitizer component (tgalopin, wouterj)
 * feature #46045 [Translation] Improve LocaleSwitcher a bit (nicolas-grekas)
 * feature #42403 [Validator] Define which collection keys should be checked for uniqueness (wkania)
 * feature #44405 [Routing] Allow using services in the route condition (renanbr)
 * feature #46009 [FrameworkBundle] Add support for first-class callable route controller in MicroKernelTrait (fancyweb)
 * feature #44155 [FrameworkBundle] Add semaphore configuration (jderusse)
 * feature #45803 [Routing] Add EnumRequirement to help generate route requirements from a \BackedEnum (fancyweb)
 * feature #45724 [FrameworkBundle] Add support to set BinaryFileResponse::trustXSendfileTypeHeader over config (alexander-schranz)
 * feature #45092 [HttpFoundation] Send `Content-Length` when calling `Response::send()` and the content is a non-empty string (nicolas-grekas)
 * feature #45967 [Messenger] Consume a PSR-14 dispatcher for dispatching events (derrabus)
 * feature #45951 [Notifier] [OvhCloud] Add `no_stop_clause` to DSN (alamirault)
 * feature #45795 [ExpressionLanguage] Add support for null-safe operator (mytuny)
 * feature #45605 [Form] Add prototype_options to CollectionType (michaelKaefer)
 * feature #45912 [ExpressionLanguage] Add some more operators (fabpot)
 * feature #45656 [Serializer] Add serializer profiler (mtarld)
 * feature #45072 [Validator] Allow creating constraints with required arguments (norkunas)
 * feature #43239 [Finder] Look for gitignore patterns up to git root (julienfalque)
 * feature #45845 [TwigBundle]  Pre-compile only *.twig files in cache warmup (GromNaN)
 * feature #44446 [Mailer] Improve extensibility of `EsmtpTransport` (ampaze)
 * feature #45226 [PhpUnitBridge] Add option `ignoreFile` to configure a file that lists deprecation messages to ignore (mondrake)
 * feature #43163 [Messenger] Add Redis Sentinel support (norbertschultheisz)
 * feature #43701 [HttpKernel] Simplifying Bundle/Extension config definition (yceruto)
 * feature #45873 [HttpFoundation] Allow dynamic session "ttl" when using a remote storage (nicolas-grekas)
 * feature #45878 [DependencyInjection] Add argument type `closure` to help passing closures to services (nicolas-grekas)
 * feature #44898 [Ldap] LDAP authentication should return a meaningful error when the LDAP server is unavailable (Jayfrown)
 * feature #45090 [Validator] Improve Image constraint invalid mime type message (fancyweb)
 * feature #42997 [Cache] Improve reliability and performance of `TagAwareAdapter` by making tag versions an integral part of item value (Sergey Belyshkin, nicolas-grekas)
 * feature #45512 [DependencyInjection] Allow using expressions as service factories (nicolas-grekas, jvasseur)
 * feature #45273 [Messenger] Allow AsMessageHandler attribute on methods (mjpvandenberg, fabpot)
 * feature #44284 [SecurityBundle] Display the inherited roles of the logged-in user in the WDT (jmsche)
 * feature #44303 Add Engagespot bridge (danut007ro)
 * feature #44532 Handle CSV DSN in ZookeeperStore (qkdreyer)
 * feature #45047 [Notifier] Use Importance level to set flash message type (benr77, fabpot)
 * feature #45166 [HttpFoundation] add stale while revalidate cache header (remieuronews)
 * feature #45195 [Notifier] Add Sendberry notifier bridge (StaffNowa)
 * feature #45793 [FrameworkBundle][Translation] add `LocaleSwitcher` service (kbond)
 * feature #45833 [HttpKernel] Add Http Status 423 LockedHttpException (xosofox)
 * feature #45705 [FrameworkBundle] Deprecate the messenger.reset_on_message config option (upyx)
 * feature #45812 [HttpClient] Improve default content-type handling (nicolas-grekas)
 * feature #45783 [DependencyInjection] adjust `Autowire` attribute implementation (kbond)
 * feature #44171 [Config] Add comment on array methods (jderusse)
 * feature #45657 [DependencyInjection] add `Autowire` parameter attribute (kbond)
 * feature #45725 [Finder] Fix SplFileInfo PHPDoc (InvisibleSmiley)
 * feature #44948 [Console] Add completion values to input definition (GromNaN)
 * feature #45745 [ErrorHandler][HttpKernel] Read SYMFONY_IDE to render exception in case of fatal error (GromNaN)
 * feature #45765 Mailer - Display email recipients in Profiler (raziel057)
 * feature #45094 Add generics to ArgumentMetadata::getAttributes (Seldaek)
 * feature #45761 Throw access denied if CurrentUser cannot be resolved instead of a 500 (Seldaek)
 * feature #45680 [DependencyInjection] use `#[Required]` for `ServiceSubscriberTrait::setContainer()` (kbond)
 * feature #45624 [Config] Allow using environment variables in `EnumNode` (ecourtial)
 * feature #45484 Make constraint violation interfaces stringable (HypeMC)
 * feature #43931 [HttpClient][WebProfilerBundle] Add button to copy a request as a cURL command (Deuchnord)
 * feature #45515 [BrowserKit] Add `toArray` to `Response` (HypeMC)
 * feature #45658 [Routing] Avoid double encoded slashes in query parameters (usu)
 * feature #45062 [PropertyInfo] Add PHP 8.0 promoted properties `@param` mutation support to PhpDocExtractor (raphaelvoisin)
 * feature #44522 [Messenger] add TransportMessageIdStamp to RedisSender (GaryPEGEOT)
 * feature #45623 [Validator] Deprecate constraint "ExpressionLanguageSyntax", use "ExpressionSyntax" instead (mpiot)
 * feature #45563 Deprecate requiring the "symfony/symfony" package (nicolas-grekas)
 * feature #45616 [HttpClient] Remove credentials from requests redirected to same host but different port (GromNaN)
 * feature #45377 Bump minimum version of PHP to 8.1 (nicolas-grekas)
 * feature #45421  [Translation] Add the possibilty to export xliff translation with the .xliff suffix (DanielBadura)
 * feature #45152 Ability to customize payload when sending mail through mailjet+api (gam6itko)
 * feature #44665 [HttpKernel] Add the UidValueResolver argument value resolver (fancyweb)
 * feature #44073 [ExpressionLanguage] Support lexing numbers with underscores and decimals with no leading zero (fancyweb)
 * feature #44721 [Serializer] Deprecate support for abstract uid denormalization in UidNormalizer (fancyweb)
 * feature #44615 [Routing] Support the "attribute" type (alias of "annotation") in annotation loaders (fancyweb)
 * feature #45265 [HttpKernel] Add Profiler::isEnabled() method (Bilge)
 * feature #45449 [Mime] Added getter for "TextPart::$name" (MasterRO94)
 * feature #45402 make Message classes extensible (bitgandtter)
 * feature #45476 [HttpKernel] Deprecate StreamedResponseListener, it serves no purpose anymore (nicolas-grekas)
 * feature #45436 [Messenger] Support setting `connection_name` for AMQP (a.dmitryuk)
 * feature #45450 [DependencyInjection] Add an env function to DI expression language (jvasseur)
 * feature #45388 [Mailer] Allow manually start() of SmtpTransport (jannick-holm)
 * feature #45376 [Mime] Fix embed logic for background attributes (flack)
 * feature #45360 [ErrorHandler] trigger deprecations for ``@final`` properties (nicolas-grekas, fancyweb)
 * feature #45371 [Validator] Deprecate `Constraint::$errorNames` in favor of `Constraint::ERROR_NAMES` (nicolas-grekas)
 * feature #44692 [Cache][FrameworkBundle] add `cache:pool:invalidate-tags` command (kbond)
 * feature #45361 [Console] Deprecate the `$defaultName` property (derrabus)
 * feature #45313 [Cache] Add support for ACL auth in RedisAdapter (gam6itko)
 * feature #45303 [ErrorHandler] Report overridden @final constants (fancyweb)
 * feature #44484 [Translation] [Loco] Send `If-Modified-Since` header when possible (Kocal)
 * feature #45307 [Mailer] Allow manually stop() of SmtpTransport (dvaeversted)
 * feature #43973 [Serializer] Add context builders (mtarld)
 * feature #45222 [Mailer] Implement EmailTags for Amazon Mailer (driesvints, kbond)
 * feature #44670 [SecurityBundle] Allow to specify a RequestMatcher directly in an ACL definition (TristanPouliquen)
 * feature #45139 [Notifier] smsapi-notifier `fast` option to sending message with the highest priority (marphi)
 * feature #45155 [Serializer] Set context annotation as not final (benjaminmal)
 * feature #44503 [FrameworkBundle] Allow PHP configuration in config/packages by default (dreadnip)
 * feature #45101 [Form] Add inputmode attribute on NumberType (welcoMattic)
 * feature #45075 [Routing] Enrich MissingMandatoryParametersException (adrienlucas)
 * feature #45064 [Messenger] Add sessionToken option to SQS transport (filkaris)
 * feature #44917 [Mailer] Add downloadable attachments to profiler (dbrekelmans)
 * feature #45054 [Routing] Allow using UTF-8 parameter names (nicolas-grekas)
 * feature #44360 [Notifier] [Bridge] [KazInfoTeh] added the bridge (taranovegor)
 * feature #44874 [Notifier] Added 46elks notifier bridge (jongotlin)
 * feature #44913 [Notifier] Add Orange SMS bridge (enigma972)
 * feature #44971 [Messenger] Resolve handled classes when only method in tag is provided (angelov)
 * feature #43982 [Messenger][Serializer] Deprecate "context aware" interfaces (mtarld)
 * feature #44790 [Serializer] Give more hints when an attribute is not correctly used (lyrixx)
 * feature #44831 [HttpKernel] Add a controller argument resolver for backed enums (ogizanagi)
 * feature #44589 [Messenger] add SerializedMessageStamp (nikophil)
 * feature #41750 [Yaml] Double-quote strings with single quote marks (Ostrzyciel)
 * feature #44774 Add `exclude` to `TaggedIterator` and `TaggedLocator` (ruudk)
 * feature #44681 [HtmlSanitizer] Introduce HtmlSanitizer component (tgalopin)
 * feature #44311 [Mime] add DraftEmail (kbond)
 * feature #44746 [Console] Add method `__toString()` to `InputInterface` (boesing)
 * feature #44568 [HttpClient] Allow yielding Exception from MockResponse's  $body to mock transport errors (fancyweb)
 * feature #44672 [Translation] Translatable parameters (sylfabre)
 * feature #44451 [PropertyInfo] Add support for phpDocumentor and PHPStan pseudo-types (EmilMassey)
 * feature #44575 [Framework] Read env var SYMFONY_IDE by default for framework.ide (GromNaN)
 * feature #43641 [Console] Issue 43602 : Add fish completion (guillaume-a)
 * feature #44150 [Assets] Accept empty `base_url`, in order to simplify local dev configuration. (GromNaN)
 * feature #44137 [Mailer] [Mailgun] Allow multiple TagHeaders with MailgunApiTransport (starred-gijs)
 * feature #44543 [HttpFoundation] Update cookie date time format (chapterjason)
 * feature #44483 [HttpKernel][WebProfilerBundle] adding xdebug_info page to webprofilerbundle (chr-hertel)

