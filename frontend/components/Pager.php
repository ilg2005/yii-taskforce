<?php

namespace frontend\components;

use yii\widgets\LinkPager;

class Pager extends LinkPager
{
    public const PAGE_CSS_CLASS = 'pagination__item';

    public $hideOnSinglePage = true;
    public $pageCssClass = self::PAGE_CSS_CLASS;
    public $maxButtonCount = 3;
    public $activePageCssClass = self::PAGE_CSS_CLASS . '--current';
    public $nextPageLabel = '&nbsp;';
    public $nextPageCssClass = [self::PAGE_CSS_CLASS];
    public $prevPageLabel = '&nbsp;';
    public $prevPageCssClass = self::PAGE_CSS_CLASS;
    public $options = ['class' => 'new-task__pagination-list'];

}
