<?php
/**
 * 
 */
namespace App\Controller;

// use Cake\Controller\Controller;
// use Cake\Event\Event;

/**
 * Application Controller
 *
 * Questions Controller
 */
class QuestionsController extends AppController
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
    public function initialize()
    {
        parent::initialize();

        // $this->loadComponent('RequestHandler', [
        //     'enableBeforeRedirect' => false,
        // ]);
        // $this->loadComponent('Flash');

        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
    }

    /**
     * 質問一覧画面
     */
    public function index()
    {
        // Controller::$paginate; で設定されているデフォ２０件
        $questions = $this->paginate($this->Questions->find(),
        [
            'order'=>['Questions.id' => 'DESC']
        ]);
        $this->set(compact('questions'));
    }
    /**
     * 質問投稿画面
     */
    public function add()
    {
        $question = $this->Questions->newEntity();
        if($this->request->is('post')){
            // フォームの処理
            // patchEntity()で既存のEntityにマージ
            $question = $this->Questions->patchEntity($question, $this->request->getData());
            $question->user_id = 1; 
            // DBへ保存
            if($this->Questions->save($question)){
                //Flashは通知用メッセージ
                $this->Flash->success('質問を投稿しました');
                return $this->redirect(['action'=>'index']);//成功したらトップへ
            }
            $this->Flash->error('質問の投稿に失敗しました');
        }
        $this->set(compact('question')); //失敗したら質問画面へ
    }
}
