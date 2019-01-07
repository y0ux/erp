<?php
namespace console\controllers;

use \Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        //$auth = $auth = new \yii\rbac\PhpManager();
        $auth->removeAll();

        // add "createPost" permission
        $createBrand = $auth->createPermission('createBrand');
        $createBrand->description = 'Create a brand';
        $auth->add($createBrand);

        // add "updatePost" permission
        $updateBrand = $auth->createPermission('updateBrand');
        $updateBrand->description = 'Update brand';
        $auth->add($updateBrand);

        // add "author" role and give this role the "createPost" permission
        $author = $auth->createRole('author');
        $auth->add($author);
        $auth->addChild($author, $createBrand);

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $updateBrand);
        $auth->addChild($admin, $author);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        //$auth->assign($author, 2);
        //$auth->assign($admin, 1);
    }
}
