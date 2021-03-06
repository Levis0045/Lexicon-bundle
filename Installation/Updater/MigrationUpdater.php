<?php
/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Claroline\LexiconBundle\Installation\Updater;

use Claroline\InstallationBundle\Updater\Updater;
use Doctrine\DBAL\Migrations\Configuration\Configuration;
use Doctrine\DBAL\Migrations\Version;
use Symfony\Component\DependencyInjection\ContainerInterface;




class MigrationUpdater extends Updater
{
    private $container;
    private $conn;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->conn = $container->get('database_connection');
    }

    public function preInstall()
    {
        if ($this->conn->getSchemaManager()->tablesExist(['claro_lexicon'])) {
            $this->log('Found existing database schema: skipping install migration...');
            $config = new Configuration($this->conn);
            $config->setMigrationsTableName('doctrine_clarolinelexiconbundle_versions');
            $config->setMigrationsNamespace('claro_lexicon'); // required but useless
            $config->setMigrationsDirectory('claro_lexicon'); // idem
            $version = new Version($config, '20150429114010', 'stdClass');
            $version->markMigrated();
        }
    }
}
