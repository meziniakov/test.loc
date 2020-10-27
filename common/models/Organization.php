<?php

namespace common\models;

use Yii;
use creocoder\taggable\TaggableBehavior;
use common\models\Adresses;
use common\models\Opinions;
use common\models\OrgToCat;
use common\models\Tag;
use common\models\query\OrganizationQuery;

/**
 * This is the model class for table "organization".
 *
 * @property int $org_id
 * @property string $org_type
 * @property string $org_name
 * @property string $org_description
 * @property int|null $org_phone
 * @property int $org_category
 * @property float $lon
 * @property float $lat
 * @property int $links_id
 * @property int $opinions_id
 *
 * @property Adresses[] $adresses
 * @property Opinions[] $opinions
 * @property OrgToCat[] $orgToCats
 * @property SocLinks[] $socLinks
 */
class Organization extends \yii\db\ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 1;

    public function behaviors()
    {
        return [
            'taggable' => [
                'class' => TaggableBehavior::class,
                'tagValuesAsArray' => false,
                'tagRelation' => 'tags',
                'tagValueAttribute' => 'name',
                'tagFrequencyAttribute' => 'frequency',
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%organization}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'required'],
            [['description'], 'string'],
            ['published_at', 'default',
            'value' => function () {
                return date(DATE_ATOM);
                }
            ],
            ['published_at', 'filter', 'filter' => 'strtotime'],
            [['status', 'category_id', 'author_id', 'updater_id', 'created_at', 'updated_at', 'phone'], 'integer'],
            [['type', 'name', 'slug', 'keywords'], 'string', 'max' => 255],
            ['status', 'default', 'value' => self::STATUS_DRAFT],
            ['author_id', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['author_id' => 'id']],
            ['category_id', 'exist', 'skipOnError' => true, 'targetClass' => CompanyCategory::class, 'targetAttribute' => ['category_id' => 'id']],
            ['updater_id', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updater_id' => 'id']],
            ['tagValues', 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Org ID',
            'type' => 'Org Type',
            'name' => 'Org Name',
            'description' => 'Org Description',
            'phone' => 'Org Phone',
            'category' => 'Org Category',
            'tagValues' => 'Tags',
        ];
    }

    /**
     * Gets query for [[Adresses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdresses()
    {
        return $this->hasMany(Adresses::class, ['id' => 'org_id']);
    }

    /**
     * Gets query for [[Opinions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOpinions()
    {
        return $this->hasMany(Opinions::class, ['id' => 'org_id']);
    }

    /**
     * Gets query for [[OrgToCats]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrgToCats()
    {
        return $this->hasMany(OrgToCat::class, ['id' => 'org_id']);
    }

        /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(CompanyCategory::class, ['id' => 'category_id']);
    }

        /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(CompanyCategory::class, ['id' => 'parent_id']);
    }

    public function getParentName()
    {
        $parent = $this->parent;

        return $parent ? $parent->name : '';
    }

    /**
     * Gets query for [[SocLinks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSocLinks()
    {
        return $this->hasMany(SocLinks::class, ['id' => 'org_id']);
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new OrganizationQuery(get_called_class());
    }

    public function getTags()
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])
            ->viaTable('{{%org_id_tag_id}}', ['org_id' => 'id']);
    }
}
