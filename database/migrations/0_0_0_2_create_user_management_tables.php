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
            ->userProfiles() // @todo change to Common\PersonalProfile ?
            ->companyProfiles() // @todo change to Common\CompanyProfile ?
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
        Schema::dropIfExists('user_profiles');
        Schema::dropIfExists('company_profiles');
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
            $table->increments('id');
            $table->string('name');

            $table->timestamps();
            $table->softDeletes();
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
            $table->increments('id');
            $table->string('name');
            $table->string('guard')->default('rocXolid');
            $table->boolean('is_exclusive')->default(0);
            $table->boolean('is_self_assignable')->default(0);
            $table->boolean('is_self_unassignable')->default(0);

            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
        });

        DB::statement("INSERT INTO `roles` (`name`) VALUES ('Admin')");
        DB::statement("INSERT INTO `roles` (`name`) VALUES ('Customer')");

        return $this;
    }

    protected function users()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('api_token', 80)->unique()->nullable();
            $table->rememberToken();

            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
        });

        return $this;
    }

    protected function userProfiles()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('language_id')->default(101); // slovak
            $table->unsignedInteger('nationality_id')->default(1); // slovak
            $table->enum('legal_entity', ['natural', 'juridical'])->default('natural');
            $table->string('email');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->date('birthdate')->nullable();
            $table->enum('gender', ['m', 'f'])->nullable();
            $table->string('bank_account_no')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('id_card_no')->nullable();
            $table->string('passport_no')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('language_id')
                ->references('id')
                ->on('languages')
                ->onDelete('cascade');

            $table->foreign('nationality_id')
                ->references('id')
                ->on('nationalities')
                ->onDelete('cascade');
        });

        return $this;
    }

    protected function companyProfiles()
    {
        Schema::create('company_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('country_id')->nullable();
            $table->string('email');
            $table->string('name');
            $table->date('established')->nullable();
            $table->string('company_registration_no')->nullable();
            $table->string('company_insertion_no')->nullable();
            $table->string('tax_no')->nullable();
            $table->string('vat_no')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('country_id')
                ->references('id')
                ->on('countries')
                ->onDelete('set null');
        });

        return $this;
    }

    protected function permissions()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_enabled')->default(1);
            $table->string('name');
            $table->string('guard')->default('rocXolid');
            $table->string('package');
            $table->string('controller_class')->nullable();
            $table->string('model_class')->nullable();
            $table->string('attribute')->nullable();
            $table->string('policy_ability_group')->nullable();
            $table->string('policy_ability')->nullable();
            $table->json('scopes')->nullable();

            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->index('guard');
            $table->index('controller_class');
            $table->index('model_class');
            $table->index('attribute');
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
            $table->enum('directive', ['allow', 'deny'])->default('allow');
            // $table->json('scope_type')->nullable();
            $table->string('scope_type')->nullable();

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
            $table->enum('directive', ['allow', 'deny'])->default('allow');
            // $table->json('scope_type')->nullable();
            $table->string('scope_type')->nullable();

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