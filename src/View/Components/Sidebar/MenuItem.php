<?php

namespace Future\LaraAdmin\View\Components\Sidebar;

use Exception;
use Illuminate\Support\Collection;

/**
 * Class MenuItem
 * @property string         $title
 * @property string         $link
 * @property string         $icon
 * @property array          $notification
 * @property bool           $active
 * @property Collection     $child
 *
 * @package App\View\Components\Sidebar
 */
class MenuItem
{
    private array $item;

    /**
     * MenuItem constructor.
     * @param string $title
     * @param bool $active
     * @param string|null $link
     * @param string|null $icon
     * $notification = array(
     *      'type' => 'warning|error|info|',
     *      'text' => ''
     * )
     * @param array|null $notification
     * @param Collection|null $child
     * @throws Exception
     */
    public function __construct(
        string $title,
        bool $active = false,
        ?string $link = null,
        ?string $icon = null,
        ?array $notification = null,
        ?Collection $child = null
    )
    {
        $data = [
            'title' => $title,
            'link' => $link,
            'icon' => $icon,
            'notification' => $notification,
            'child' => $child ?? new Collection(),
            'active' => $active,
        ];

        $this->validate($data);

        $this->item = $data;
    }

    /**
     * @throws Exception
     */
    private function validate(array $data): void
    {
        switch (true) {
            case ! is_null($data['notification']) && ! isset($data['notification']['type']):
                throw new Exception('Массив notification должен содержать элемент с ключом type');
            case ! is_null($data['notification']) && ! isset($data['notification']['text']):
                throw new Exception('Массив notification должен содержать элемент с ключом text');
        }
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get(string $name): mixed
    {
        if (isset($this->item[$name])){
            return $this->item[$name];
        }

        return null;
    }
}
