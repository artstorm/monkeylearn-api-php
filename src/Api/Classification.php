<?php

namespace Artstorm\MonkeyLearn\Api;

class Classification extends ApiAbstract
{
    /**
     * Perform the classification of many text samples.
     *
     * @link   http://docs.monkeylearn.com/article/api-reference/#Classify_POST
     *
     * @param  array  $text
     * @param  string $classifierId
     *
     * @return array
     */
    public function classify(array $text, $classifierId)
    {
        $parameters = ['text_list' => $text];

        return $this->post(
            sprintf('classifiers/%s/classify/', $classifierId),
            $parameters
        );
    }
}
