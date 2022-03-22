<?php

namespace WipeOutInc\Seat\SeatBuyback\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use WipeOutInc\Seat\SeatBuyback\Exceptions\SettingsException;

class SettingsHelper
{

    /**
     * @var SettingsHelper
     */
    private static $instance;

    /**
     * @var array
     */
    private $_settings;

    /**
     * Constructor
     */
    private function __construct()
    {
        $this->loadSettings();
    }

    /**
     * @param string $setting
     * @return string
     * @throws SettingsException
     */
    public function getSetting(string $setting): string
    {

        if (!array_key_exists($setting, $this->_settings)) {
            throw new SettingsException("Admin setting: \"" . $setting . "\" could not be found! Please check your database records!");
        }
        return $this->_settings[$setting];
    }

    /**
     * @param string $key
     * @param string $value
     * @return void
     * @throws SettingsException
     */
    public function setSetting(string $key, string $value): void
    {

        if (!array_key_exists($key, $this->_settings)) {
            throw new SettingsException("Admin setting key: \"" . $key . "\" could not be found! Please check your database records!");
        }

        try {
            DB::table('buyback_admin_config')
                ->where('name', $key)
                ->update(['value' => $value]);
        } catch (QueryException $e) {
            \Log::error('QueryException: ' . $e->getMessage());
        }
    }

    /**
     * @param array $newSettings
     * @return void
     */
    public function setAllSettings(array $newSettings): void
    {

        if (count($newSettings) <= 0) {
            return;
        }

        foreach ($newSettings as $key => $value) {

            if ($key != "_token") {
                try {
                    if ($this->_settings[$key] != $value) {
                        $this->setSetting($key, $value);
                    }
                } catch (SettingsException $e) {
                    \Log::error('SettingException: ' . $e->getMessage());
                }
            }
        }
    }

    /**
     * @return array
     */
    public function getAllSettings(): array
    {
        return $this->_settings;
    }

    /**
     * @return void
     */
    private function loadSettings(): void
    {

        try {
            $settingData = DB::table('buyback_admin_config')
                ->get();

            foreach ($settingData as $item) {
                $this->_settings[$item->name] = $item->value;
            }
        } catch (QueryException $e) {
            \Log::error('QueryException: ' . $e->getMessage());
        }
    }

    /**
     * @return SettingsHelper
     */
    public static function getInstance(): SettingsHelper
    {
        if (!isset(self::$instance)) {
            self::$instance = new SettingsHelper();
        }

        return self::$instance;
    }
}
