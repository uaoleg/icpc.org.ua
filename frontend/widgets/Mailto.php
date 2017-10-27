<?php

namespace frontend\widgets;

class Mailto extends BaseWidget {

    /**
     * Title for link
     * @var string
     */
    public $title;

    /**
     * Email of link
     * @var string
     */
    public $email;

    /**
     * Custom html attributes
     * @var array
     */
    public $attr = array();

    /**
     * Run widget
     */
    public function run()
    {
        $email = str_replace('@', '&#64;', $this->obfuscate($this->email));

        $title = $this->title ?: $email;

        $email = $this->obfuscate('mailto:') . $email;

        return $this->render(
            'mailto',
            array(
                'email' => $email,
                'title' => htmlentities($title, ENT_QUOTES, 'UTF-8', false),
                'attributes' => $this->attributes($this->attr)
            )
        );
    }


    /**
     * Obfuscate a string to prevent spam-bots from sniffing it.
     *
     * @param  string  $value
     * @return string
     */
    protected function obfuscate($value)
    {
        $safe = '';

        foreach (str_split($value) as $letter)
        {
            if (ord($letter) > 128)
            {
                return $letter;
            }

            // To properly obfuscate the value, we will randomly convert each letter to
            // its entity or hexadecimal representation, keeping a bot from sniffing
            // the randomly obfuscated letters out of the string on the responses.
            switch (rand(1, 3))
            {
                case 1:
                    $safe .= '&#'.ord($letter).';';
                    break;
                case 2:
                    $safe .= '&#x'.dechex(ord($letter)).';';
                    break;
                case 3:
                    $safe .= $letter;
            }
        }

        return $safe;
    }

    /**
     * Build an HTML attribute string from an array.
     *
     * @param  array  $attributes
     * @return string
     */
    public function attributes($attributes)
    {
        $html = array();

        // For numeric keys we will assume that the key and the value are the same
        // as this will convert HTML attributes such as "required" to a correct
        // form like required="required" instead of using incorrect numerics.
        foreach ((array) $attributes as $key => $value)
        {
            $element = $this->attributeElement($key, $value);

            if (!is_null($element))
            {
                $html[] = $element;
            }
        }

        return count($html) > 0 ? ' '.implode(' ', $html) : '';
    }

    /**
     * Build a single attribute element.
     *
     * @param  string  $key
     * @param  string  $value
     * @return string
     */
    protected function attributeElement($key, $value)
    {
        if (is_numeric($key))
        {
            $key = $value;
        }

        if (!is_null($value))
        {
            return $key . '="' . htmlentities($value, ENT_QUOTES, 'UTF-8', false) . '"';
        }
    }

}