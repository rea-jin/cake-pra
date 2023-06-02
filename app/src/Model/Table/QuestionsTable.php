<?php
/**
 * 
 */
namespace App\Model\Table;

use Cake\ORM\Table;
// use Cake\Controller\Controller;
// use Cake\Event\Event;

/**
 * Application Model
 *
 * Questions Model
 */
class QuestionsTable extends Table
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('questions'); // 指定されるテーブル名
        $this->setDisplayField('id'); // 1ist形式でデータを湯トクする際に使用する
        $this->setPrimaryKey('id'); // primary key
        $this->addBehavior('Timestamp'); // created, modified
        
        // 外部キーとして、QuestionテーブルのIDを指定して JOINしている
        $this->hasMany('Answers',['foreignKey'=>'question_id']);
    }

}
