<?php
/*
 * This file is part of the "Lost and Found" project
 *
 * (c) Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Composer;

use Composer\Script\Event;

/**
 * Class Heroku Environment
 *
 * @author Artem Genvald      <genvaldartem@gmail.com>
 * @author Andrew Prohorovych <prohorovychua@gmail.com>
 */
class HerokuEnvironment
{
    /**
     * Populate Heroku environment
     *
     * @param Event $event Event
     */
    public static function populateEnvironment(Event $event)
    {
        $url = getenv('HEROKU_POSTGRESQL_IVORY_URL');

        if ($url) {
            $url = parse_url($url);
            putenv("SYMFONY__DATABASE_DRIVER=pdo_pgsql");
            putenv("SYMFONY__DATABASE_HOST={$url['host']}");
            putenv("SYMFONY__DATABASE_USER={$url['user']}");
            putenv("SYMFONY__DATABASE_PASSWORD={$url['pass']}");

            $db = substr($url['path'], 1);
            putenv("SYMFONY__DATABASE_NAME={$db}");
        }

        $io = $event->getIO();

        $databaseUrl = getenv('HEROKU_POSTGRESQL_IVORY_URL');
        if (!empty($databaseUrl)) {
            $io->write('HEROKU_POSTGRESQL_IVORY_URL=' . $databaseUrl);
        }
    }
}
