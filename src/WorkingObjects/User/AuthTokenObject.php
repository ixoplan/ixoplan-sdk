<?php

namespace Ixolit\Dislo\WorkingObjects\User;


use Ixolit\Dislo\WorkingObjects\AbstractWorkingObject;

/**
 * Class AuthTokenObject
 *
 * @package Ixolit\Dislo\WorkingObjects
 */
final class AuthTokenObject extends AbstractWorkingObject {

    /** @var int */
    private $id;

    /** @var int */
    private $userId;

    /** @var string */
    private $token;

    /** @var \DateTime */
    private $createdAt;

    /** @var \DateTime */
    private $modifiedAt;

    /** @var \DateTime */
    private $validUntil;

    /** @var string */
    private $metaInfo;

    /**
     * @param int       $id
     * @param int       $userId
     * @param string    $token
     * @param \DateTime $createdAt
     * @param \DateTime $modifiedAt
     * @param \DateTime $validUntil
     * @param string    $metaInfo
     */
    public function __construct(
        $id,
        $userId,
        $token,
        \DateTime $createdAt,
        \DateTime $modifiedAt,
        \DateTime $validUntil,
        $metaInfo
    ) {
        $this->id         = $id;
        $this->userId     = $userId;
        $this->token      = $token;
        $this->createdAt  = $createdAt;
        $this->modifiedAt = $modifiedAt;
        $this->validUntil = $validUntil;
        $this->metaInfo   = $metaInfo;
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUserId() {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getToken() {
        return $this->token;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getModifiedAt() {
        return $this->modifiedAt;
    }

    /**
     * @return \DateTime
     */
    public function getValidUntil() {
        return $this->validUntil;
    }

    /**
     * @return string
     */
    public function getMetaInfo() {
        return $this->metaInfo;
    }

    /**
     * @param $response
     *
     * @return AuthTokenObject
     */
    public static function fromResponse($response) {
        return new self(
            static::getValue($response, 'id'),
            static::getValue($response, 'userId'),
            static::getValue($response, 'loginToken'),
            static::getValueAsDateTime($response, 'createdAt'),
            static::getValueAsDateTime($response, 'modifiedAt'),
            static::getValueAsDateTime($response, 'validUntil'),
            static::getValue($response, 'metaInfo')
        );
    }

    /**
     * @return array
     */
    public function toArray() {
        return [
            'id'         => $this->id,
            'userId'     => $this->userId,
            'loginToken' => $this->token,
            'createdAt'  => $this->createdAt->format('Y-m-d H:i:s'),
            'modifiedAt' => $this->modifiedAt->format('Y-m-d H:i:s'),
            'validUntil' => $this->validUntil->format('Y-m-d H:i:s'),
            'metaInfo'   => $this->metaInfo,
        ];
    }

    /**
     * @return string
     */
    public function __toString() {
        return $this->token;
    }

}