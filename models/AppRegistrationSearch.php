<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AppRegistration;

/**
 * AppDetailSearch represents the model behind the search form of `app\models\AppDetail`.
 */
class AppRegistrationSearch extends AppRegistration {
//    public static function getDb() {
//        return \Yii::$app->db_api;
//    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'app_user_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['imei_no', 'os_type', 'manufacturer_name', 'os_version', 'firebase_token', 'app_version', 'date_of_install', 'date_of_uninstall'], 'safe'],
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
    public function search($params, $user_model = null, $pagination = true) {
        $query = AppRegistration::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
            'sort' => ['defaultOrder' => ['date_of_install' => SORT_DESC]],
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
            'date_of_install' => $this->date_of_install,
            'date_of_uninstall' => $this->date_of_uninstall,
            'status' => $this->status,
            'created_at' => $this->created_at,
         
            'updated_at' => $this->updated_at,
            
        ]);

        $query->andFilterWhere(['like', 'imei_no', $this->imei_no])
                ->andFilterWhere(['like', 'os_type', $this->os_type])
                ->andFilterWhere(['like', 'manufacturer_name', $this->manufacturer_name])
                ->andFilterWhere(['like', 'os_version', $this->os_version])
                ->andFilterWhere(['like', 'firebase_token', $this->firebase_token])
                ->andFilterWhere(['like', 'app_version', $this->app_version]);

        return $dataProvider;
    }

}
