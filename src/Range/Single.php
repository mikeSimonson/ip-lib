<?php

namespace IPLib\Range;

use IPLib\Address\AddressInterface;
use IPLib\Factory;

/**
 * Represents a single address (eg a range that contains just one address).
 *
 * @example 127.0.0.1
 * @example ::1
 */
class Single implements RangeInterface
{
    /**
     * @var AddressInterface
     */
    protected $address;

    /**
     * Initializes the instance.
     *
     * @param AddressInterface $address
     */
    protected function __construct(AddressInterface $address)
    {
        $this->address = $address;
    }

    /**
     * Try get the range instance starting from its string representation.
     *
     * @param string|mixed $range
     *
     * @return static|null
     */
    public static function fromString($range)
    {
        $result = null;
        $address = Factory::addressFromString($range);
        if ($address !== null) {
            $result = new static($address);
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     *
     * @see RangeInterface::toString()
     */
    public function toString($long = false)
    {
        return $this->address->toString($long);
    }

    /**
     * {@inheritdoc}
     *
     * @see RangeInterface::__toString()
     */
    public function __toString()
    {
        return $this->address->__toString();
    }

    /**
     * {@inheritdoc}
     *
     * @see RangeInterface::getAddressType()
     */
    public function getAddressType()
    {
        return $this->address->getAddressType();
    }

    /**
     * {@inheritdoc}
     *
     * @see RangeInterface::contains()
     */
    public function contains(AddressInterface $address)
    {
        $result = false;
        if ($address->getAddressType() === $this->getAddressType()) {
            if ($address->toString(false) === $this->address->toString(false)) {
                $result = true;
            }
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     *
     * @see RangeInterface::getComparableStartString()
     */
    public function getComparableStartString()
    {
        return $this->address->getComparableString();
    }

    /**
     * {@inheritdoc}
     *
     * @see RangeInterface::getComparableEndString()
     */
    public function getComparableEndString()
    {
        return $this->address->getComparableString();
    }
}
