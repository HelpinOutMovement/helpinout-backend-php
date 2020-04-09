<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RequestHelp;

/**
 * RequestHelpSearch represents the model behind the search form of `app\models\RequestHelp`.
 */
class RequestHelpSearch extends RequestHelp
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'app_user_id', 'api_log_id', 'master_category_id', 'no_of_items', 'accuracy', 'payment', 'created_at', 'updated_at', 'status'], 'integer'],
            [['request_uuid', 'location', 'address', 'datetime', 'time_zone_offset'], 'safe'],
            [['lat', 'lng'], 'number'],
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
        $query = RequestHelp::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'app_user_id' => $this->app_user_id,
            'api_log_id' => $this->api_log_id,
            'master_category_id' => $this->master_category_id,
            'no_of_items' => $this->no_of_items,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'accuracy' => $this->accuracy,
            'payment' => $this->payment,
            'datetime' => $this->datetime,
            'time_zone_offset' => $this->time_zone_offset,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'request_uuid', $this->request_uuid])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'address', $this->address]);

        return $dataProvider;
    }
}
