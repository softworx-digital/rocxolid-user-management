<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserManagementTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this
            ->groups()
            ->roles()
            ->users()
            ->permissions()
            ->passwordResets()
            ->rolePermissions()
            ->modelRoles()
            ->modelPermissions()
            ->modelGroups();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schema::dropIfExists('groups');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('users');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('role_has_permissions');
        Schema::dropIfExists('model_has_roles');
        Schema::dropIfExists('model_has_permissions');
        Schema::dropIfExists('model_has_groups');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    protected function groups()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->string('name');
            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
        });

        DB::statement("INSERT INTO `groups` (`name`) VALUES ('Default')");

        return $this;
    }

    protected function roles()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->string('name');
            $table->string('guard_name')->default('auth.rocXolid');
            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
        });

        DB::statement("INSERT INTO `roles` (`name`) VALUES ('Admin')");

        return $this;
    }

    protected function users()
    {
        // users
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->unsignedInteger('language_id')->default(101); // slovak
            $table->string('name');
            $table->string('birthnumber')->nullable();
            $table->string('email')->unique();
            $table->string('login')->unique();
            $table->string('password');
            $table->string('password_unhashed')->nullable();
            $table->timestamp('last_action')->nullable();
            $table->timestamp('logged_out')->nullable();
            $table->timestamp('days_first_login')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->foreign('language_id')
                ->references('id')
                ->on('languages')
                ->onDelete('cascade');
        });

        return $this;
    }

    protected function permissions()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->string('name');
            $table->string('guard_name')->default('auth.rocXolid');
            $table->string('controller_class')->nullable();
            $table->string('controller_method_group')->nullable();
            $table->string('controller_method')->nullable();
            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
        });

        return $this;
    }

    protected function passwordResets()
    {
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        return $this;
    }

    protected function rolePermissions()
    {
        Schema::create('role_has_permissions', function (Blueprint $table) {
            $table->unsignedInteger('permission_id');
            $table->unsignedInteger('role_id');

            $table->foreign('permission_id')
                ->references('id')
                ->on('permissions')
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');

            $table->primary(['permission_id', 'role_id']);
        });

        return $this;
    }

    protected function modelRoles()
    {
        Schema::create('model_has_roles', function (Blueprint $table) {
            $table->unsignedInteger('role_id');
            $table->morphs('model');

            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');

            $table->primary(['role_id', 'model_id', 'model_type']);
        });

        return $this;
    }

    protected function modelPermissions()
    {
        Schema::create('model_has_permissions', function (Blueprint $table) {
            $table->unsignedInteger('permission_id');
            $table->morphs('model');

            $table->foreign('permission_id')
                ->references('id')
                ->on('permissions')
                ->onDelete('cascade');

            $table->primary(['permission_id', 'model_id', 'model_type']);
        });

        return $this;
    }

    protected function modelGroups()
    {
        Schema::create('model_has_groups', function (Blueprint $table) {
            $table->unsignedInteger('group_id');
            $table->morphs('model');

            $table->foreign('group_id')
                ->references('id')
                ->on('groups')
                ->onDelete('cascade');

            $table->primary(['group_id', 'model_id', 'model_type']);
        });

        return $this;
    }
}