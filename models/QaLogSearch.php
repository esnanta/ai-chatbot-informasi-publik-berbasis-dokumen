<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\QaLog;

/**
 * QaLogSearch represents the model behind the search form of `app\models\QaLog`.
 */
class QaLogSearch extends QaLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'upvote', 'downvote'], 'integer'],
            [['question', 'answer', 'created_at'], 'safe'],
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
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = QaLog::find()->orderBy(['created_at' => SORT_DESC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'upvote' => $this->upvote,
            'downvote' => $this->downvote,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'question', $this->question])
            ->andFilterWhere(['like', 'answer', $this->answer]);

        return $dataProvider;
    }
}
