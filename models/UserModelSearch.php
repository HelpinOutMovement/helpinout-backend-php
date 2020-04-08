<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UserModel;

/**
 * UserModelSearch represents the model behind the search form of `app\models\UserModel`.
 */
class UserModelSearch extends UserModel {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'role_id', 'confirmed_at', 'blocked_at', 'created_at', 'updated_at', 'flags', 'last_login_at'], 'integer'],
            [['username', 'name', 'mobile_no', 'email', 'password_hash', 'auth_key', 'unconfirmed_email', 'registration_ip'], 'safe'],
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
        $query = UserModel::find();



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
            'role_id' => $this->role_id,
            'confirmed_at' => $this->confirmed_at,
            'blocked_at' => $this->blocked_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'flags' => $this->flags,
            'last_login_at' => $this->last_login_at,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
                ->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'mobile_no', $this->mobile_no])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['like', 'password_hash', $this->password_hash])
                ->andFilterWhere(['like', 'auth_key', $this->auth_key])
                ->andFilterWhere(['like', 'unconfirmed_email', $this->unconfirmed_email])
                ->andFilterWhere(['like', 'registration_ip', $this->registration_ip]);

        return $dataProvider;
    }

}
