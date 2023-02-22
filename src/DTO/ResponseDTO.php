<?php

namespace App\DTO;

/**
 *
 */
class ResponseDTO
{
    private string $view;

    private array $options;

    /**
     * @param string $view
     * @param array  $options
     */
    public function __construct(string $view, array $options)
    {
        $this->view = $view;
        $this->options = $options;
    }

    /**
     * @return string
     */
    public function getView(): string
    {
        return $this->view;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}