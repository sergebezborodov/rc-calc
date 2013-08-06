<?php


class CopterInfoWidget extends CWidget
{
    /**
     * @var CopterCalcModel
     */
    public $calcModel;

    public $showDelete = true;

    /**
     * Рендеринг
     */
    public function run()
    {
        $formula = new CopterCalcFormula($this->calcModel);
        $this->render('copter-info', array(
            'model' => $this->calcModel,
            'calc'  => $formula->calculate(),
        ));
    }
}
