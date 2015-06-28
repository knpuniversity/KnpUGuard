<?php

namespace KnpU\Guard\Exception;

use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * An authentication exception where you can add a message that will
 * be shown to the user, without needing to create a sub-class
 *
 *  throw CustomAuthenticationException::createWithSafeMessage(
 *      'That was a ridiculous username'
 *  );
 */
class CustomAuthenticationException extends AuthenticationException
{
    private $messageKey;

    private $messageData;

    /**
     * Helper method to create this exception and set the safe message
     * that will be shown to the user.
     *
     * @param string $safeMessage
     * @param array $messageData
     * @param int $code
     * @param \Exception $previous
     * @return CustomAuthenticationException
     */
    static public function createWithSafeMessage($safeMessage = "", array $messageData = array(), $code = 0, \Exception $previous = null)
    {
        $exception = new static($safeMessage, $code, $previous);
        $exception->setSafeMessage($safeMessage, $messageData);

        return $exception;
    }

    /**
     * Set a message that will be shown to the user
     *
     * @param string $messageKey The message or message key
     * @param array $messageData Data to be passed into the translator
     */
    public function setSafeMessage($messageKey, array $messageData)
    {
        $this->messageKey = $messageKey;
        $this->messageData = $messageData;
    }

    public function getMessageKey()
    {
        return $this->messageKey !== null ? $this->messageKey : parent::getMessageKey();
    }

    public function getMessageData()
    {
        return $this->messageData !== null ? $this->messageData : parent::getMessageData();
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize(array(
            $this->messageKey,
            $this->messageData,
            parent::serialize(),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($str)
    {
        list($this->messageKey, $this->messageData, $parentData) = unserialize($str);

        parent::unserialize($parentData);
    }
}
