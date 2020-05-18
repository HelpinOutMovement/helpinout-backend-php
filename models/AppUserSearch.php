<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AppUser;

/**
 * AppUserSearch represents the model behind the search form of `app\models\AppUser`.
 */
class AppUserSearch extends AppUser {

    public $name;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'mobile_no_visibility', 'user_type', 'master_app_user_org_type', 'status'], 'integer'],
            [['time_zone', 'time_zone_offset', 'country_code', 'mobile_no', 'first_name', 'last_name', 'org_name', 'org_division'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
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
    public function search($params) {
        $query = AppUser::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>["pageSize"=>100],
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
            'time_zone_offset' => $this->time_zone_offset,
            'mobile_no_visibility' => $this->mobile_no_visibility,
            'user_type' => $this->user_type,
            'master_app_user_org_type' => $this->master_app_user_org_type,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'time_zone', $this->time_zone])
                ->andFilterWhere(['like', 'country_code', $this->country_code])
                ->andFilterWhere(['like', 'mobile_no', $this->mobile_no])
                ->andFilterWhere(['like', "CONCAT(firstname, ' ', lastname)", $this->name])
                ->andFilterWhere(['like', 'first_name', $this->first_name])
                ->andFilterWhere(['like', 'last_name', $this->last_name])
                ->andFilterWhere(['like', 'org_name', $this->org_name])
                ->andFilterWhere(['like', 'org_division', $this->org_division]);

        return $dataProvider;
    }

}
