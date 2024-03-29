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
        $this->loadModel('Answers'); // これでAnswersモデルが使用可能になる

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

    // 質問詳細画面
    /**
     * @param int $id
     * @return void
     */
    public function view(int $id)
    {
        $question = $this->Questions->get($id); // findと異なり、存在しなければ404エラー

        $answers = $this
        ->Answers
        ->find()
        ->where(['Answers.question_id' => $id])
        ->orderAsc('Answers.id')
        ->all(); // 100件に制限しているのでall()でとる

        $newAnswer = $this->Answers->newEntity();

        $this->set(compact('question','answers','newAnswer'));

    }
    /**
     * 質問削除処理
     * @param int $id
     * @return
     */
    public function delete(int $id)
    {
        $this->request->allowMethod(['post']);

        $question = $this->Questions->get($id);
        //質問を削除できるのは質問投稿者
        if($this->Questions->delete($question))
        {
            $this->Flash->success('質問を削除しました');
        }else{
            $this->Flash->error('質問の削除に失敗しました');
        }

        return $this->redirect(['action'=>'index']);
    }
}
