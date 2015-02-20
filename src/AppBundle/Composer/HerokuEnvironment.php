<?php

namespace AppBundle\Composer;

use Composer\Script\Event;

/**
 * Class Heroku Environment
 *
 * @author Artem Genvald      <GenvaldArtem@gmail.com>
 * @author Andrew Prohorovych <ProhorovychUA@gmail.com>
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
        $url = getenv('CLEARDB_DATABASE_URL');

        if ($url) {
            $url = parse_url($url);
            putenv("SYMFONY__DATABASE_HOST={$url['host']}");
            putenv("SYMFONY__DATABASE_USER={$url['user']}");
            putenv("SYMFONY__DATABASE_PASSWORD={$url['pass']}");

            $db = substr($url['path'], 1);
            putenv("SYMFONY__DATABASE_NAME={$db}");
        }

        $io = $event->getIO();

        $databaseUrl = getenv('CLEARDB_DATABASE_URL');
        if (!empty($databaseUrl)) {
            $io->write('CLEARDB_DATABASE_URL=' . $databaseUrl);
        }
    }
}
