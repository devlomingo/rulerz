<?php

namespace RulerZ\Compiler\Target\Sql;

use PommProject\ModelManager\Model\Model as PommModel;

use RulerZ\Compiler\Context;
use RulerZ\Compiler\Visitor\Sql\PommVisitor;

class Pomm extends AbstractSqlTarget
{
    /**
     * @inheritDoc
     */
    public function supports($target, $mode)
    {
        // we make the assumption that pomm models use at least the
        // \PommProject\ModelManager\Model\ModelTrait\ReadQueries trait
        return $target instanceof PommModel;
    }

    /**
     * @inheritDoc
     */
    protected function createVisitor(Context $context)
    {
        return new PommVisitor($context, $this->getOperators(), $this->getInlineOperators(), $this->allowStarOperator);
    }

    /**
     * @inheritDoc
     */
    protected function getExecutorTraits()
    {
        return [
            '\RulerZ\Executor\Pomm\FilterTrait',
            '\RulerZ\Executor\Polyfill\FilterBasedSatisfaction',
        ];
    }
}
