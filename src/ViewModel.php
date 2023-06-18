<?php
namespace Phpshots\Viewmodel;
use Phpshots\Viewmodel\Interfaces\EventInterface;

abstract class ViewModel {
    protected $data;
    protected $templatePath;
    protected $layout;
    protected $contentTemplate;
    protected $contentHtml;
    protected $renderedContentHtml = "";
    protected $eventConfig;

    protected $eventCallbacks = [];

    // Event priority constants
    const EVENT_PRIORITY_LOW = 0;
    const EVENT_PRIORITY_MEDIUM = 1;
    const EVENT_PRIORITY_HIGH = 2;

    /**
     * ViewModel constructor.
     *
     * @param array $data The data to be passed to the template.
     */
    public function __construct($data = []) {
        $this->data = $data;
        $this->templatePath = "Views"; // Default template path

        $this->registerEventCallbacks();
    }

      /**
     * Set the event configuration.
     *
     * @param EventInterface $eventConfig
     */
    public function setEventConfig(EventInterface $eventConfig) {
        $this->eventConfig = $eventConfig;
        $this->registerEventCallbacks();
    }

    /**
     * Register the event callbacks.
     */
    abstract protected function registerEventCallbacks();

    /**
     * Add an event callback with the specified event name, callback, and priority.
     *
     * @param string   $eventName
     * @param callable $callback
     * @param int      $priority
     */
    public function addEventCallback(string $eventName, callable $callback, int $priority = 0) {
        if (!isset($this->eventCallbacks[$eventName])) {
            $this->eventCallbacks[$eventName] = [];
        }

        $this->eventCallbacks[$eventName][] = [
            'callback' => $callback,
            'priority' => $priority,
        ];

        // Sort the event callbacks by priority
        usort($this->eventCallbacks[$eventName], function ($a, $b) {
            return $a['priority'] <=> $b['priority'];
        });
    }

/**
     * Trigger the event callbacks for the specified event name.
     *
     * @param string $eventName
     */
    protected function triggerEvent(string $eventName) {
        if (isset($this->eventCallbacks[$eventName])) {
            foreach ($this->eventCallbacks[$eventName] as $eventCallback) {
                $callback = $eventCallback['callback'];
                $viewModel = $callback($this);

                if ($viewModel instanceof ViewModel) {
                    $this->mergeViewModelData($viewModel);
                }
            }
        }
    }

     /**
     * Merge the data from a ViewModel instance.
     *
     * @param ViewModel $viewModel
     */
    protected function mergeViewModelData(ViewModel $viewModel) {
        $this->data = array_merge($this->data, $viewModel->getData());
    }

    public function getData() {
        return $this->data;
    }

    public function setData(array $newData) {
         $this->data = $newData;
    }

    /**
     * Set the layout file.
     *
     * @param string $layout The layout file.
     */
    public function setLayout($layout) {
        $this->layout = $layout;
    }

    /**
     * Set the content template.
     *
     * @param string $template The content template.
     */
    public function setContentTemplate($template) {
        $this->contentTemplate = $template;
    }

    /**
     * Set the content HTML.
     *
     * @param string $html The content HTML.
     */
    public function setContentHtml($html) {
        $this->contentHtml = $html;
    }

    /**
     * Get the content HTML.
     *
     * @return string
     */
    public function getContentHtml() {
        return $this->contentHtml;
    }

    /**
     * Get the rendered content HTML.
     *
     * @return string
     */
    public function getRenderedContentHtml() {
        return $this->renderedContentHtml;
    }

    /**
     * Render the template with event callbacks.
     */
    public function render() {
        $this->triggerEvent('beforeRender');
        $this->renderBody();
        $this->renderLayout();
        $this->triggerEvent('afterRender');
    }

    /**
     * Render the body of the template.
     */
    protected function renderBody() {
        if (empty($this->contentHtml)) {
            $this->contentHtml = $this->renderTemplateToString($this->contentTemplate);
        }

        $this->data['body'] = $this->contentHtml;
    }

    /**
     * Render the layout of the template.
     */
    protected function renderLayout() {
        $this->renderedContentHtml = $this->renderTemplateToString($this->layout);
    }

    /**
     * Render a template to string.
     *
     * @param string $templatePath The path to the template file.
     *
     * @return string
     *
     * @throws \Exception
     */
    private function renderTemplateToString($templatePath) {
        $templateFile = DIRECTORY_SEPARATOR.trim($this->templatePath,DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . trim(implode(DIRECTORY_SEPARATOR,explode('.',$templatePath)),DIRECTORY_SEPARATOR) . '.php';
        if (file_exists($templateFile)) {
            extract($this->data);
            ob_start();
            include $templateFile;
            return ob_get_clean();
        } else {
            throw new \Exception("Template file not found: $templateFile");
        }
    }

       /**
     * Magic method to convert the object to a string.
     *
     * @return string
     */
    public function __toString(): string {
        if(empty($this->renderedContentHtml)) $this->render();
        
        return $this->renderedContentHtml;
    }
}
