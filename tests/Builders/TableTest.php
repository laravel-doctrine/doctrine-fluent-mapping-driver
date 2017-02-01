<?php

namespace Tests\Builders;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use LaravelDoctrine\Fluent\Builders\Table;
use Tests\Stubs\Entities\StubEntity;

class TableTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ClassMetadataBuilder
     */
    protected $builder;

    /**
     * @var Table
     */
    protected $table;

    protected function setUp()
    {
        $this->builder = new ClassMetadataBuilder(new ClassMetadataInfo(StubEntity::class));
        $this->table   = new Table($this->builder);
    }

    public function test_can_be_constructed_with_a_name_string()
    {
    	new Table($this->builder, 'users');

        $this->assertEquals('users', $this->builder->getClassMetadata()->getTableName());
    }

    public function test_it_ignores_empty_names()
    {
    	$this->assertNull($this->builder->getClassMetadata()->table);
    }

    public function test_it_can_be_constructed_with_a_callback_instead_of_a_name()
    {
    	new Table($this->builder, function(Table $builder){
             $builder->setName('crazy_logic');
        });

        $this->assertEquals('crazy_logic', $this->builder->getClassMetadata()->getTableName());
    }

    public function test_can_set_name()
    {
        $this->table->setName('users');

        $this->assertEquals('users', $this->builder->getClassMetadata()->getTableName());
    }

    public function test_detects_schema_from_names()
    {
        $this->table->setName('some_schema.users');

        $this->assertEquals('some_schema', $this->builder->getClassMetadata()->getSchemaName());
    }

    public function test_can_change_only_the_schema()
    {
        $this->table->schema('a_schema');

        $this->assertEquals('a_schema', $this->builder->getClassMetadata()->getSchemaName());
    }
}
