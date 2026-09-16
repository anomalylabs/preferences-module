<?php namespace Anomaly\PreferencesModule\Preference;

use Dotenv\Dotenv;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Env;

/**
 * Class PreferenceEnvironment
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class PreferenceEnvironment
{

    /**
     * The application instance.
     *
     * @var Application
     */
    protected $application;

    /**
     * The parsed environment file.
     *
     * @var array|null
     */
    protected $file = null;

    /**
     * Create a new PreferenceEnvironment instance.
     *
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * Return whether a preference is pinned to an environment variable.
     *
     * Preferences may be declared as a field type slug
     * rather than an array of definition.
     *
     * @param  mixed $preference
     * @return bool
     */
    public function pinned($preference)
    {
        if (!is_array($preference) || !isset($preference['env'])) {
            return false;
        }

        if (Env::getRepository()->get($preference['env']) !== null) {
            return true;
        }

        return array_key_exists($preference['env'], $this->file());
    }

    /**
     * Return the parsed environment file.
     *
     * The environment file is not parsed into the environment
     * once the configuration is cached, so it is read here
     * directly rather than through env().
     *
     * @return array
     */
    protected function file()
    {
        if ($this->file !== null) {
            return $this->file;
        }

        $path = $this->application->environmentFilePath();

        if (!is_file($path)) {
            return $this->file = [];
        }

        return $this->file = Dotenv::createArrayBacked(dirname($path), basename($path))->safeLoad();
    }
}
