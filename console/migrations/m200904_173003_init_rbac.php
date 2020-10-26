<?php

use yii\db\Migration;

/**
 * Class m200904_173003_init_rbac
 */
class m200904_173003_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $create = $auth->createPermission('createEntities');
        $create->description = 'Create Entities';
        $auth->add($create);

        $create = $auth->createPermission('fullRoot');
        $create->description = 'Crud Root';
        $auth->add($create);

        $update = $auth->createPermission('updateEntities');
        $update->description = 'Update Entities';
        $auth->add($update);

        $delete = $auth->createPermission('deleteEntities');
        $delete->description = 'Delete Entities';
        $auth->add($delete);

        $view = $auth->createPermission('viewEntities');
        $view->description = 'view Entities';
        $auth->add($view);

        $mangeRoots = $auth->createPermission('mangeRoots');
        $mangeRoots->description = 'Mange Roots';
        $auth->add($mangeRoots);

        $managePermission = $auth->createPermission('managePermission');
        $managePermission->description = 'Manage Permission';
        $auth->add($managePermission);

        // add "author" role and give this role the "createPost" permission
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $create);
        $auth->addChild($admin, $update);
        $auth->addChild($admin, $delete);
        $auth->addChild($admin, $view);

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $root = $auth->createRole('root');
        $auth->add($root);
        $auth->addChild($root, $mangeRoots);
        $auth->addChild($root, $managePermission);
        $auth->addChild($root, $update);
        $auth->addChild($root, $delete);
        $auth->addChild($root, $view);
        $auth->addChild($root, $admin);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($root, 1);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200904_173003_init_rbac cannot be reverted.\n";

        return false;
    }

}
