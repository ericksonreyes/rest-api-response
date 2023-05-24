<?php

namespace EricksonReyes\RestApiResponse;

/**
 * Class Links
 * @package EricksonReyes\RestApiResponse
 */
class Links extends Collection implements LinksInterface
{

    /**
     * @param \EricksonReyes\RestApiResponse\LinkInterface $link
     * @return void
     */
    public function addLink(LinkInterface $link): void
    {
        $this->addItem($link);
    }

    /**
     * @return array|\EricksonReyes\RestApiResponse\LinkInterface[]
     */
    public function links(): array
    {
        return $this->items();
    }
}
