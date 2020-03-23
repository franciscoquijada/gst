<?php
namespace App\Library\Services;
  
use Illuminate\Session\Store;
  
class PNotifier
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
    public function message($text, $title = false, $type = 'info')
    {
        $this->config['text'] = $text;
        $this->config['title'] = $title;
        $this->config['type'] = $type;
        $this->setMessage();
    }

    /**
     * Success message
     *
     * @param $text
     * @param $title
     * @return $this
     */
    public function success($text, $title = false)
    {
        $this->message( $text, $title, 'success' );

        //return $this;
    }

    /**
     * Info message
     *
     * @param $text
     * @param $title
     * @return $this
     */
    public function info($text, $title = false)
    {
        $this->message($text, $title, 'info');

        return $this;
    }

    /**
     * Warning message
     *
     * @param $text
     * @param $title
     * @return $this
     */
    public function warning($text, $title = false)
    {
        $this->message($text, $title, 'notice');

        return $this;
    }

    /**
     * Danger message
     *
     * @param $text
     * @param $title
     * @return $this
     */
    public function danger($text, $title = false)
    {
        $this->message($text, $title, 'error');

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
        $this->message($text, $title, 'error');

        return $this;
    }

    /**
     * Dark message
     *
     * @param $text
     * @param $title
     * @return $this
     */
    public function dark($text, $title = false)
    {
        $this->message($text, $title, 'dark');

        return $this;
    }

    /**
     * Sticky message
     *
     * @return $this
     */
    public function sticky()
    {
        $this->config['hide'] = false;
        $this->flashConfig();

        return $this;
    }

    /**
     * Flash the configuration to the session
     */
    private function setMessage()
    {
        $this->session->flash('PNotify.alert', 
            array_merge( (array) $this->session->get('PNotify.alert'), [$this->buildConfig()] ) );
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
    		'title' 	=>  'Notificación',
    		'text' 		=>  null,
    		'type' 		=>  null,
    		'styling' 	=>  'bootstrap4',
    		'icons' 	=>  'fontawesome5'
    	];
    }
}