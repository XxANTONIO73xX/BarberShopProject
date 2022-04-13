<?php

declare (strict_types=1);
namespace RectorPrefix20211231;

use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Symfony\Rector\MethodCall\SwiftCreateMessageToNewEmailRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
// @see https://symfony.com/blog/the-end-of-swiftmailer
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Symfony\Rector\MethodCall\SwiftCreateMessageToNewEmailRector::class);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->configure([
        'Swift_Mailer' => 'Symfony\\Component\\Mailer\\MailerInterface',
        'Swift_Message' => 'Symfony\\Component\\Mime\\Email',
        // message
        'Swift_Mime_SimpleMessage' => 'Symfony\\Component\\Mime\\RawMessage',
        // transport
        'Swift_SmtpTransport' => 'Symfony\\Component\\Mailer\\Transport\\Smtp\\EsmtpTransport',
        'Swift_FailoverTransport' => 'Symfony\\Component\\Mailer\\Transport\\FailoverTransport',
        'Swift_SendmailTransport' => 'Symfony\\Component\\Mailer\\Transport\\SendmailTransport',
    ]);
};
