<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Notification;

/**
 * NotificationSearch represents the model behind the search form of `app\models\Notification`.
 */
class NotificationSearch extends Notification {

    /**
     * {@inheritdoc}
     */
    public $username;

    public function rules() {
        return [
            [['id', 'activity_type', 'master_category_id', 'request_help_id', 'offer_help_id', 'action', 'created_at', 'updated_at', 'status'], 'integer'],
            [['app_user_id'], 'safe'],
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
        $query = Notification::find()->orderBy(['id' => SORT_DESC]);

        // add conditions that should always apply here
        $query->leftJoin('app_user', 'notification.app_user_id=app_user.id');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 100],
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
//            'app_user_id' => $this->app_user_id,
            'activity_type' => $this->activity_type,
            'master_category_id' => $this->master_category_id,
            'request_help_id' => $this->request_help_id,
            'offer_help_id' => $this->offer_help_id,
            'action' => $this->action,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);
//      
        $query->andFilterWhere(['like', 'app_user.first_name', $this->app_user_id])
                ->orFilterWhere(['like', 'app_user.last_name', $this->app_user_id]);
//        
        return $dataProvider;
    }

}
