<?php
namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Video;
use app\models\User;

class VideoSearchForm extends Model {

    public $search;

     /**
     * Rules for validation of the model
     * 
     * @return array
     */
    public function rules() {
        return [
            [['search'], 'safe']
        ];
    }

    /**
     * @param  $params string $_GET parameters from the URL
     * @return object
     */
    public function search($params) { 
        $query = Video::find()->orderBy('id DESC');
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10
            ]
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }


   
        /**
         * Search for: title, url or description
         */
        $query->orFilterWhere(['like', 'title', $this->search])
            ->orFilterWhere(['like', 'url', $this->search])
            ->orFilterWhere(['like', 'description', $this->search]);


        return $dataProvider;
    }
}

?>