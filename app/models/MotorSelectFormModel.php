<?php

/**
 * Форма выбора мотора
 */
class MotorSelectFormModel extends CFormModel
{
    /**
     * @var int
     */
    public $manufacterId;

    /**
     * @var string
     */
    public $model;

    /**
     * @var int kv min
     */
    public $kvMin;

    /**
     * @var int kv max
     */
    public $kvMax;

    /**
     * @var int weight min
     */
    public $weightMin;

    /**
     * @var int weight max
     */
    public $weightMax;


    /**
     * @var string имя поля сортировки
     */
    public $sortField;

    /**
     * @var string направление сортировки
     */
    public $sortDirection;

    public function rules()
    {
        return array(
            array('manufacterId, model, kvMin, kvMax, weightMin, weightMax', 'safe'),

            array('sortField, sortDirection', 'safe'),
        );
    }


    /**
     * Поиск
     * @return MotorModel[]
     */
    public function search()
    {
        $criteria = new CDbCriteria();
        if ($this->manufacterId) {
            $criteria->compare('manufacter_id', $this->manufacterId);
        }
        if ($this->model) {
            $criteria->compare('model', $this->model, true);
        }
        if ($this->kvMin) {
            $criteria->compare('kw >', $this->kvMin);
        }
        if ($this->kvMax) {
            $criteria->compare('kw <', $this->kvMax);
        }
        if ($this->weightMin) {
            $criteria->compare('weight >', $this->weightMin);
        }
        if ($this->weightMax) {
            $criteria->compare('weight <', $this->weightMin);
        }

        $criteria->limit = 10000;
        $criteria->with = array('manufacter');
        if ($sortField = $this->getSortField()) {
            $criteria->order = $sortField . ' ' . $this->getSortDirection();
        }

        $criteria->compare('weight !', 1);

        return MotorModel::model()->findAll($criteria);
    }

    /**
     * @return string название поля сортировки
     */
    protected function getSortField()
    {
        switch ($this->sortField) {
            case 'manufacter':
                return 'manufacter.title';
            case 'model':
                return 'model';
            case 'kv':
                return 'kw';
            case 'weight':
                return 'weight';
            default:
                return null;
        }
    }

    /**
     * @return string направление сортировки
     */
    protected function getSortDirection()
    {
        return $this->sortDirection == 'asc' ? 'ASC' : 'DESC';
    }
}
