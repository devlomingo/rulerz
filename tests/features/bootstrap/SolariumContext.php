<?php

class SolariumContext extends BaseContext
{
    /**
     * @var \Solarium\Client
     */
    private $client;

    /**
     * {@inheritDoc}
     */
    protected function initialize()
    {
        $this->client = new Solarium\Client([
            'endpoint' => [
                $_ENV['SOLR_CORE'] => [
                    'host' => $_ENV['SOLR_HOST'],
                    'port' => $_ENV['SOLR_PORT'],
                    'path' => $_ENV['SOLR_PATH'],
                    'core' => $_ENV['SOLR_CORE'],
                ]
            ]
        ]);
    }

    /**
     * {@inheritDoc}
     */
    protected function getCompilationTarget()
    {
        $visitor = new \RulerZ\Compiler\Target\Solr\Solarium();
        $visitor->setInlineOperator('boost', function($expression, $factor) {
            return sprintf('%s^%d', $expression, $factor);
        });

        return $visitor;
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultDataset()
    {
        return $this->client;
    }
}
