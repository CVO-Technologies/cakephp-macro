<?php

namespace Macro\Macro;

use Cake\I18n\Time;
use Cake\ORM\Entity;
use Macro\Macro\Macro;

class EntityTimeMacro extends Macro
{

    public function createdTimeAgoInWords()
    {
        if (!$this->context() instanceof Entity) {
            return null;
        }

        if (!$this->context()->has('created')) {
            return null;
        }

        /** @var Time $time */
        $time = $this->context()->get('created');

        return $time->timeAgoInWords();
    }

    /**
     * @param null $context
     * @return Entity
     */
    public function context($context = null)
    {
        return parent::context($context);
    }

}
