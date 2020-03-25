<?php
namespace App\Library\Services;
  
use Illuminate\Session\Store;
  
class Notifier
{
    /**
     * @var SessionStore
     */
    private $session;

    private $config = [];

    /**
     * @var ConfigRepo
     */
    private $messages = [];

    /**
     * Notifier constructor.
     * @param SessionStore $session
     */
    public function __construct(Store $session)
    {
        $this->session = $session;
        $this->setDefaultConfig();
    }

    /**
     * Default message
     *
     * @param $text
     * @param bool|string $title
     * @param string $type
     */
    public function message( $title, $icon = 'info' )
    {
        $this->config['title'] = $title;
        $this->config['icon'] = $icon;
        $this->setMessage();
    }

    /**
     * Success message
     *
     * @param $text
     * @param $title
     * @return $this
     */
    public function success( $text )
    {
        $this->message( $text, 'success' );
    }

    /**
     * Info message
     *
     * @param $text
     * @param $title
     * @return $this
     */
    public function info($text)
    {
        $this->message($text, 'info');

        return $this;
    }

    /**
     * Warning message
     *
     * @param $text
     * @param $title
     * @return $this
     */
    public function warning($text)
    {
        $this->message($text, 'warning');

        return $this;
    }

    /**
     * Danger message
     *
     * @param $text
     * @param $title
     * @return $this
     */
    public function danger($text)
    {
        $this->message($text, 'error');

        return $this;
    }

    /**
     * Error message. Same as danger
     *
     * @param $text
     * @param $title
     * @return $this
     */
    public function error($text, $title = false)
    {
        $this->message($text, 'error');

        return $this;
    }

    /**
     * Sticky message
     *
     * @return $this
     */
    public function sticky()
    {
        $this->config['timer'] = false;
        $this->flashConfig();

        return $this;
    }

    /**
     * Flash the configuration to the session
     */
    private function setMessage()
    {
        $this->session->flash('Notify.alert', 
            array_merge( (array) $this->session->get('Notify.alert'), [$this->buildConfig()] ) );
    }

    /**
     * Generate the configuration for json
     *
     * @return string
     */
    private function buildConfig()
    {
        if(! $this->config['title'] )
            $this->config['title'] = 'Notificación';

        return json_encode($this->config);
    }

    /**
     * Set the default config values
     */
    private function setDefaultConfig()
    {
        $this->config = [
            'title'     =>  null,
            'icon'      =>  null
        ];
    }
}