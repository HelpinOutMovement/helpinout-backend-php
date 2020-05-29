<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LogEmailOfferMappingRequest;

/**
 * LogEmailOfferMappingRequestSearch represents the model behind the search form of `app\models\LogEmailOfferMappingRequest`.
 */
class LogEmailOfferMappingRequestSearch extends LogEmailOfferMappingRequest {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'created_at', 'updated_at', 'status'], 'integer'],
            [['email_address', 'datetime', 'app_user_id'], 'safe'],
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
        $query = LogEmailOfferMappingRequest::find();
        $query->leftJoin('app_user', 'log_email_offer_mapping_request.app_user_id=app_user.id');
//exit;
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
            'datetime' => $this->datetime,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);
        if (isset($this->app_user_id)) {
            $query
                    ->andFilterWhere(['like', 'email_address', trim($this->email_address)])
                    ->FilterWhere(['like', 'app_user.first_name', trim($this->app_user_id)])
                    ->orFilterWhere(['like', 'app_user.last_name', trim($this->app_user_id)]);
        } else {
           
        }


        return $dataProvider;
    }

}
