<?php

namespace EricksonReyes\RestApiResponse;

/**
 * Interface MetaAwareResponseInterface
 * @package EricksonReyes\RestApiResponse
 */
interface MetaAwareResponseInterface
{
    /**
     * @return \EricksonReyes\RestApiResponse\MetaInterface
     */
    public function meta(): MetaInterface;

    /**
     * @return bool
     */
    public function hasMeta(): bool;

    /**
     * @return bool
     */
    public function hasNoMeta(): bool;
}
