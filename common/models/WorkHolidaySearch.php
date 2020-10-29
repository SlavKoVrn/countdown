<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
/**
 * WorkHolidaySearch represents the model behind the search form of `common\models\WorkHoliday`.
 */
class WorkHolidaySearch extends WorkHoliday
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'holiday', 'status', 'user', 'created_at', 'updated_at'], 'integer'],
            [['name', 'stock', 'begin', 'end'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = WorkHoliday::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if (isset($this->begin)){
            $query->andFilterWhere([ '>=', 'begin', $this->begin ]);
        }

        if (isset($this->end)){
            $query->andFilterWhere([ '<=', 'end', $this->end ]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'holiday' => $this->holiday,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'stock', $this->stock]);

        return $dataProvider;
    }
}
