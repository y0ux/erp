<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "company".
 *
 * @property string $id
 * @property string $short_name
 * @property string $legal_name
 * @property string $nit
 * @property string $details
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Brand $brand
 * @property Brand[] $brands
 * @property Business[] $businesses
 * @property CompanyAddress[] $companyAddresses
 * @property Address[] $addresses
 * @property CompanyBankAccount[] $companyBankAccounts
 * @property firstBankAccount $firstBankAccount
 * @property BankAccount[] $bankAccounts
 * @property Product[] $products
 * @property Staff[] $staff
 * @property UserCompany[] $userCompanies
 * @property User[] $users
 * @property User $user
 * @property Vehicle[] $vehicles
 * @property Venue[] $venues
 */
class Company extends \yii\db\ActiveRecord
{

    /*const BREWERY = 1;
    const SUPPLIER = 2;
    const RESTAURANT = 3;
    const OTHER = 4;
    //public $company_types = [1 => 'Brewery', 2 => 'Supplier', 3 => 'Restaurant', 4 => 'Other'];*/
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['short_name', 'legal_name', 'nit'], 'required'],
            [['details'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['short_name', 'legal_name', 'nit'], 'string', 'max' => 255],
            [['legal_name'], 'unique'],
            [['nit'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sys.company', 'ID'),
            'short_name' => Yii::t('sys.company', 'Short Name'),
            'legal_name' => Yii::t('sys.company', 'Legal Name'),
            'nit' => Yii::t('sys.company', 'Nit'),
            'details' => Yii::t('sys.company', 'Details'),
            'created_at' => Yii::t('sys.company', 'Created At'),
            'updated_at' => Yii::t('sys.company', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
              'class' => TimestampBehavior::className(),
              'value' => date('Y-m-d H:i:s',time()),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }
        $bank_accounts = $this->bankAccounts;
        foreach ($bank_accounts as $account)
          $account->delete();
        $brands = $this->brands;
        foreach ($brands as $brand)
          $brand->delete();
        return true;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrands()
    {
        return $this->hasMany(Brand::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusinesses()
    {
        return $this->hasMany(Business::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyAddresses()
    {
        return $this->hasMany(CompanyAddress::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(Address::className(), ['id' => 'address_id'])->viaTable('company_address', ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyBankAccounts()
    {
        return $this->hasMany(CompanyBankAccount::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBankAccounts()
    {
        return $this->hasMany(BankAccount::className(), ['id' => 'bank_account_id'])->viaTable('company_bank_account', ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasMany(Staff::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserCompanies()
    {
        return $this->hasMany(UserCompany::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('user_company', ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicles()
    {
        return $this->hasMany(Vehicle::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVenues()
    {
        return $this->hasMany(Venue::className(), ['company_id' => 'id']);
    }



    /* CUSTOM FUNCTIONS */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brand::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFirstBankAccount()
    {
        return $this->hasOne(BankAccount::className(), ['id' => 'bank_account_id'])->viaTable('company_bank_account', ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id'])->viaTable('user_company', ['company_id' => 'id']);
    }



    /* *
     * @return Array
     * /
    public static function getTakenStands()
    {
        $list = self::find()->all();
        $stands = [];
        foreach ($list as $item)
          $stands[$item->stand] = $item->stand;
        return $stands;
    }

    /* *
     * @return Array
     * /
    public static function getTakenCompanyStands()
    {
        $list = self::find()->all();
        $stands = [];
        foreach ($list as $item)
          $stands[$item->stand] = $item->legal_name;
        return $stands;
    } */

    /* *
     * @return Array
     * /
    public static function getCompanyTypes()
    {
        return [
          self::BREWERY => \Yii::t('eventplanner.company', 'Brewery'),
          self::SUPPLIER => \Yii::t('eventplanner.company', 'Supplier'),
          self::RESTAURANT => \Yii::t('eventplanner.company', 'Restaurant'),
          self::OTHER => \Yii::t('eventplanner.company', 'Other'),
        ];
    }*/

    /* *
     * @return Array
     * /
    public static function getCompaniesByType($type)
    {
        $companies = self::find()->all();
        $list = [];
        foreach($companies as $company)
          if ($company->company_type_id == $type)
            $list[$company->id] = $company;
        //sort($list, SORT_NUMERIC);
        return $list;
    }*/

    /* *
     * @return Array
     * /
    public static function getCompaniesByTypeByStand($type)
    {
        $companies = self::getCompaniesByType($type);
        $list = [];
        foreach($companies as $company)
            $list[$company->stand] = $company;
        return $list;
    }*/

    /**
     * @return Array
     */
    public function getCompanyLimits()
    {
      $event_limits = null;
      if (!empty(Yii::$app->params['event.limits']['custom'][$this->id])) {
        $event_limits = Yii::$app->params['event.limits']['custom'][$this->id];
      } else
        $event_limits = Yii::$app->params['event.limits'][$this->company_type_id];
      return $event_limits;
    }
}
