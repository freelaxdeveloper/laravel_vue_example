<?php namespace App\Services;

use App\Models\Setting as MSetting; // Model settings

/**
 * Class Setting
 * @package App\Services
 */
class Setting
{
    /**
     * @var String
     */
  public $type;
    /**
     * @var mixed
     */
  public $settings;

    /**
     * Setting constructor.
     * @param String $name
     */
  public function __construct(String $name)
  {
    $this->type = $name;
    $this->settings = $this->getSettings();
  }

    /**
     * @return mixed
     */
  protected function getSettings()
  {
    $settings = $this->getModel()['settings'];
    return $settings;
  }

    /**
     * @return MSetting
     */
  protected function getModel()
  {
    if ($settings = $this->settings()->where('name', $this->type)->first()) {
      return $settings;
    }
    $settings = new MSetting;
    $settings->name = $this->type;
    $settings->settings = config("settings_default.{$this->type}");
    $settings->save();

    return $settings;
  }

    /**
     * @param array $settings
     * @return bool
     */
  public function save(array $settings): bool
  {
    return $this->getModel()->update(['settings' => $settings]);
  }

    /**
     * @return mixed
     */
  protected function settings()
  {
    static $settings;

    if (!$settings) {
      $settings = MSetting::get();
    }
    return $settings;
  }
}
