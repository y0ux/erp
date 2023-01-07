<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\SignupInvitation;

use common\models\Currency;
use common\models\ExchangeRate;
use common\models\CashierRecord;
use common\models\CashierTransaction;
use common\models\CashboxDetail;

/**
 * Signup form
 */
class CashboxForm extends Model
{
    // información
    public $record_type;
    // ingresos y salidas
    public $cash_gtq;
    public $cash_usd;
    public $card;
    public $transfer;
    public $gift_card;
    public $other;
    public $spent;
    // quetzales
    public $q200;
    public $q100;
    public $q50;
    public $q20;
    public $q10;
    public $q5;
    public $q1;
    public $q05;
    public $q025;
    public $q01;
    public $q005;
    public $q001;
    // dolares
    public $d100;
    public $d50;
    public $d20;
    public $d10;
    public $d5;
    public $d1;

    private $transactions_types = [
        'cash_gtq' => [
            'flow' => CashierTransaction::FLOW_IN,
            'type' => CashierTransaction::TYPE_CASH_GTQ,
            'currency' => 'gtq' // create base currency
        ],
        'cash_usd' => [
            'flow' => CashierTransaction::FLOW_IN,
            'type' => CashierTransaction::TYPE_CASH_USD,
            'currency' => 'usd',
            'exhange_rate' => 7
        ],
        'card' => [
            'flow' => CashierTransaction::FLOW_IN,
            'type' => CashierTransaction::TYPE_CARD,
            'currency' => 'gtq'
        ],
        'transfer' => [
            'flow' => CashierTransaction::FLOW_IN,
            'type' => CashierTransaction::TYPE_TRANSFER,
            'currency' => 'gtq'
        ],
        'gift_card' => [
            'flow' => CashierTransaction::FLOW_IN,
            'type' => CashierTransaction::TYPE_GIFT,
            'currency' => 'gtq'
        ],
        'other' => [
            'flow' => CashierTransaction::FLOW_IN,
            'type' => CashierTransaction::TYPE_OTHER,
            'currency' => 'gtq'
        ],
        'spent' => [
            'flow' => CashierTransaction::FLOW_OUT,
            'type' => CashierTransaction::TYPE_CASH_GTQ,
            'currency' => 'gtq'
        ],
    ];

    private $notes = [
        'gtq' => [
          'denominations' => ['q200' => 20000, 'q100' => 10000, 'q50' => 5000, 'q20' => 2000, 'q10' => 1000, 'q5' => 500, 'q1' => 100, 'q05' => 50, 'q025' => 25, 'q01' => 10, 'q005' => 5, 'q001' => 1],
          'exchange_rate' => 1,
        ],
        'usd' => [
            'denominations' => ['d100' => 10000, 'd50' => 5000, 'd20' => 2000, 'd10' => 1000, 'd5' => 500, 'd1' => 100],
            'exchange_rate' => 7,
        ]
    ];
    private $significant_decimal = 2;
    public $base_cashbox = 3000;
    private $totals = [
        'totals' => ['cash_gtq', 'cash_usd', 'card', 'transfer', 'gift_card', 'other', 'spent'],
    ];


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['record_type', 'required'],
            ['record_type', 'in', 'range' => [CashierRecord::RECORD_OPENING, CashierRecord::RECORD_CLOSING]],

            [['cash_gtq','cash_usd','card','transfer','gift_card','other', 'spent'], 'number', 'min' => '0' ],
            [['cash_gtq','cash_usd','card','transfer','gift_card','other', 'spent'], 'default' ],
            [
              [
                'q200','q100','q50','q20','q10','q5','q1','q05','q025','q01', 'q005','q001',
                'd100','d50','d20','d10','d5','d1'
              ],
              'integer', 'min' => '0' ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        
    }

    /**
     * Signs user up.
     *
     * @return CashierRecord|null the saved model or null if saving fails
     */
    public function processRecord()
    {
        Yii::debug(print_r("process Record: ", true));

        if (!$this->validate()) {
            //Yii::$app->session->setFlash('error', 'Validation fail.');
            return null;
        }
        // lets process bills
        $cashbox = [
            'grand_total' => 0,
            'base_cashbox' => $this->base_cashbox,
            'cashbox_difference' => 0
        ];
        $cashbox_details = [];
        foreach ($this->notes as $currency => $note_config) {
            $cashbox [$currency] = ['totalGTQ' => 0]; // create totalBase var
            $note_list = $note_config ['denominations'];
            $exchange_rate = $note_config ['exchange_rate'];
            $currency_obj = Currency::findCurrencyByISO($currency);
            if (!$currency_obj) {
                Yii::debug(print_r("currency not found: ".$currency, true));
                return null;
            }
            if ($exchange_rate != 1)  // remove if totalBase
                $cashbox [$currency]['total'.$currency] = 0;
            foreach ($note_list as $var_name => $note_value) {
                if (!empty($this->$var_name) && $this->{$var_name} > 0) {
                    if ($exchange_rate != 1)    // remove if totalBase exist
                        $cashbox [$currency]['total'.$currency] = $this->$var_name * $note_value / 100;
                    $cashbox [$currency][$var_name] = $this->$var_name * $note_value * $exchange_rate / 100;
                    $cashbox [$currency]['totalGTQ'] += $cashbox [$currency][$var_name]; // change to totalBase
                    // create object
                    $cd = new CashboxDetail();
                    $cd->currency_id = $currency_obj->id;
                    $cd->currency_name = $currency_obj->name;
                    $cd->currency_symbol = $currency_obj->symbol;
                    $cd->currency_value = $note_value/100;
                    $cd->quantity = $this->$var_name;
                    $cd->total_value = $this->$var_name * $note_value / 100; // create variable totalBase
                    $cd->exchange_rate_id = null;
                    $cd->exhange_rate_value = $exchange_rate;
                    $cd->total_rated = $cashbox [$currency][$var_name];

                    $cashbox_details[] = $cd;

                }
            }
            $cashbox['grand_total'] += $cashbox [$currency]['totalGTQ'];
        }

        if($cashbox['grand_total'] <= 0) {
            Yii::$app->session->setFlash('error', Yii::t('erp.sys', 'La caja no puede estar a 0'));
            return null;
        }

        $cashbox['cashbox_difference'] = $cashbox['grand_total'] - $cashbox['base_cashbox'];
        Yii::debug(print_r("cashbox var: ", true));
        Yii::debug(print_r($cashbox, true));
        Yii::debug(print_r($this->record_type, true));
        Yii::debug(print_r($cashbox_details, true));


        $cashier_record = new CashierRecord();
        $cashier_record->created_by_user_id = Yii::$app->user->identity->id;
        $cashier_record->created_by_username = Yii::$app->user->identity->username;
        $cashier_record->created_by_full_name = Yii::$app->user->identity->getFullName();
        $cashier_record->record_type = $this->record_type;
        $cashier_record->cashbox_total = $cashbox['grand_total'];
        $cashier_record->income_total = ($cashbox['cashbox_difference'] > 0 ? $cashbox['cashbox_difference'] : 0) + $this->card + $this->transfer + $this->gift_card + $this->other;
        $cashier_record->outcome_total = $this->spent;
        Yii::debug(print_r($cashier_record, true));

        $cashier_record_transaction = CashierRecord::getDb()->beginTransaction();
        try {
            if ($cashier_record->validate()) {
                Yii::debug('record valid ');
                if ($cashier_record->save()) {
                    Yii::debug('record saved ');
                    // process cashbox

                    $data_success = true;
                    $detail_trans_list = CashboxDetail::getDb()->beginTransaction();
                    foreach ($cashbox_details as $detail) {
                      $detail->cashier_record_id = $cashier_record->id;

                      if ($detail->validate() && $detail->save()) {
                          Yii::debug('detail saved ');
                      }
                      else {
                          $data_success = false;
                          Yii::$app->session->addFlash('error', Yii::t('erp.sys', 'Error al ingresar detalle de caja'));
                          Yii::debug(print_r($detail,true));
                          Yii::debug('aca detail failed ');

                          $detail_trans_list->rollBack();
                          break;
                      }
                    }

                    if ($data_success) {
                        $variables_trans_list = CashierTransaction::getDb()->beginTransaction();
                        Yii::debug(print_r($this->transactions_types,true));
                        foreach ($this->transactions_types as $var_name => $var_config) {
                            if ($this->$var_name > 0) {
                                $currency_obj = Currency::findCurrencyByISO($var_config['currency']);
                                if (empty($currency_obj)) {
                                    Yii::debug(print_r("currency not found: ".$currency, true));
                                    $data_success = false;
                                    $variables_trans_list->rollBack();
                                    break;
                                }

                                $transaction_var = new CashierTransaction();
                                $transaction_var->cashier_record_id = $cashier_record->id;
                                $transaction_var->transaction_flow = $var_config['flow'];
                                $transaction_var->transaction_type = $var_config['type'];
                                $transaction_var->currency_id = $currency_obj->id;
                                $transaction_var->currency_name = $currency_obj->name;
                                $transaction_var->currency_symbol = $currency_obj->symbol;
                                $transaction_var->total_amount = $this->$var_name;
                                if (isset($var_config['exchange_rate'])) {
                                    $transaction_var->exhange_rate_value = $var_config['exchange_rate'];
                                    $transaction_var->total_rated = $var_config['exchange_rate'] * $this->$var_name;
                                }
                                else {
                                    $transaction_var->total_rated = $this->$var_name;
                                }
                                if ($transaction_var->validate() && $transaction_var->save()) {
                                    Yii::debug('transaction saved '.$var_name);
                                }
                                else {
                                    $data_success = false;
                                    Yii::$app->session->setFlash('error', Yii::t('erp.sys', 'Error al ingresar detalle de caja'));
                                    Yii::debug('transaction failed ');
                                    Yii::debug(print_r($transaction_var, true));
                                    $variables_trans_list->rollBack();
                                    break;
                                }
                            }
                        }
                    }

                    if ($data_success) {
                        Yii::$app->session->setFlash('success', Yii::t('erp.sys', 'Informacion ingresada.'));
                        $detail_trans_list->commit();
                        $variables_trans_list->commit();
                        $cashier_record_transaction->commit();
                        return $cashier_record;
                    }
                    else {
                        throw new \Exception();
                    }
                }
            }
            else {
                Yii::$app->session->setFlash('error', Yii::t('erp.sys', 'Informacio no valida'));
                Yii::debug('record fail ');
            }
        }
        catch (\Exception $e)
        {
            $cashier_record_transaction->rollBack();
            Yii::$app->session->addFlash('error',"There was an error trying to save [".$e->getMessage()."]");
        }

        /*


        // IN
        $transactions = CashierTransaction::getTransactionTypes()
        $cashier_transaction = [];
        foreach ($transactions as $transaction => $label) {
           $ct = new CashierTransaction();
           $ct->transaction_flow = CashierTransaction::FLOW_IN;
           $ct->transaction_type = $transaction;
           switch($transaction) {
             CashierTransaction::TYPE_CASH_GTQ:

                $ct->currency_id()
                $cashier_transaction[] = $ct;
                break;
           }

        }

        $cashbox_detail = new CashboxDetail();
        */


        /*
        // get token
        $token = SignupInvitation::findToken($this->invitation_token);
        if (empty($token)) {
          //Yii::$app->session->setFlash('error', 'Token failed.');
          return null;
        }
        $user = new User();
        //$user->username = $this->username;
        $user->username = $this->email;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        Yii::$app->session->setFlash('success', 'usuario generado ');
        if ($user->save()) {
            $token->processToken($this->email);
            Yii::$app->session->setFlash('success', 'token procesado ');
            return $user;
        }
        */
        return null;
    }



}
