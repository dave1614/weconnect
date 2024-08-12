<script setup>
import {
  mdiAccountMultiple,
  mdiCartOutline,
  mdiChartTimelineVariant,
  mdiMonitorCellphone,
  mdiReload,
  mdiGithub,
  mdiChartPie,
  mdiWallet,
  mdiAccountCash,
  mdiDotsHorizontal,
} from "@mdi/js";

import { useForm, usePage, Head, Link, router } from '@inertiajs/vue3'
//import { Inertia } from '@inertiajs/inertia'
import { computed, ref, onMounted } from "vue";
import { useMainStore } from "@/Stores/main";


import * as chartConfig from "@/Components/Charts/chart.config.js";
import LineChart from "@/Components/Charts/LineChart.vue";
import SectionMain from "@/Components/SectionMain.vue";
import CardBoxWidget from "@/Components/CardBoxWidget.vue";
import CardBox from "@/Components/CardBox.vue";

import TableSampleClients from "@/Components/TableSampleClients.vue";
import NotificationBar from "@/Components/NotificationBar.vue";
import BaseButton from "@/Components/BaseButton.vue";
import CardBoxTransaction from "@/Components/CardBoxTransaction.vue";
import CardBoxClient from "@/Components/CardBoxClient.vue";
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import SectionBannerStarOnGitHub from "@/Components/SectionBannerStarOnGitHub.vue";
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import FormCheckRadioGroup from "@/Components/FormCheckRadioGroup.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import PillTag from "@/Components/PillTag.vue";
import BaseDivider from "@/Components/BaseDivider.vue";
import CardBoxModal from "@/Components/CardBoxModal.vue";




import FlashMessages from "@/Components/FlashMessages.vue";





const props = defineProps({
  user: {
    type: Object,
    
  },
  credit: {
    type: Boolean,
    default: false,
  },
  tab_open: {
    type: Number,
    default: 2,
  },
  statement: {
    type: Array,
    default: []
  },
  
  PUBLIC_KEY: {
    type: String,
  },
  paystack_payment_made: {
    type: Boolean,
    default: false,
  },
  banks_arr: {
    type: Object,
    default: {},
  },
  withdrawal_charge: {
    default: 0
  },
  
  prev_selec_bank_index: {
    default: null
  },
  min_withd_amt_naira: {
    default: 200.00
  },
  
})
const page = usePage()

const mainStore = useMainStore();

// const user = page.props.auth.user;

const errors_size = ref(0);
const tab_open = ref(props.tab_open);
const credited_text = ref("");

// const services = ref([ 'One', 'Two' ]);
const exchange_rate = ref(0.00);
const from_account = ref("");
const to_account = ref("");
const recepient_details = ref({});

const current_account = ref("");

const current_account_credit = ref("");
const current_currency_credit = ref("");

const more_options_account_type = ref("");

onMounted(() => {
  if(props.credit){
    creditAccount('naira');
  }
});

const statements_detail = ref({
  id: 16,
  user_id: 12,
  type: "naira",
  amount: "1000.00",
  amount_before: "160.00",
  amount_after: "1160.00",
  summary: "Transfer from your dollar account to your local account",
  date: "16 May 2023",
  time: "12:09:36pm",
  created_at: "2023-05-16T12:09:36.000000Z",
  updated_at: "2023-05-16T12:09:36.000000Z"
});


const showProvidusDetailsModal = ref(false);
const showStatementDetailModal = ref(false);
const showTransfEnterAmtModal = ref(false);
const showEnterUsernameForTransModal = ref(false);
const showEnterPasswordTransferModal = ref(false);
const showEnterAmtForCreditModal = ref(false);
const showChoosePaymentOptionModal = ref(false);
const showEnterWithdrawalAmtFormModal = ref(false);
const showWithdrawFundsModal = ref(false);
const showEnterPasswordWithdNairaModal = ref(false);
const showWithdrawFundsDollarModal = ref(false);
const showEnterWithdrawalAmtDollarFormModal = ref(false);
const showEnterPasswordWithdDollarModal = ref(false);
const showMoreOptionsModal = ref(false);

const paystack_url = ref("");



 

const form = useForm({
  
})

const exhange_rate_form = useForm({
  
})

const statement_details_form = useForm({
  id: null,
  
});

const transfer_to_other_acct_form = useForm({
  amount: null,
  from_account: null,
  to_account: null,
});

const transfer_to_other_user_form = useForm({
  amount: null,
  user_name: null,
  from_account: null,
  from_currency: null,
  passw: null,
  passw_confirmation: null
});

const credit_account_form = useForm({
  amount: null  
})

const withdrawal_form = useForm({
  account_type: null,
  account_symbol: null,
  amount: null,
  bank_name: props.prev_selec_bank_index != null ? props.banks_arr.obj[props.prev_selec_bank_index] : null,
  account_number: props.user.account_number,
  account_name: '',
  
  passw: null,
  passw_confirmation: null
})

const dollar_withdrawal_form = useForm({
  account_type: null,
  account_symbol: null,
  amount: null,
  crypto_wallet: props.user.crypto_wallet,
  passw: null,
  passw_confirmation: null
})





const transferBtn = (account_type) => {
  var opposite = account_type == 'dollar' ? 'naira' : 'dollar';
  Swal.fire({
    title: 'Choose Action',
    html: `Do you want to transfer to?`,
    icon: 'question',
    showCancelButton: false,
    showDenyButton: true,
    confirmButtonColor: '#3085d6',
    denyButtonColor: '#059669',
    confirmButtonText: 'Your ' + opposite + ' account',
    denyButtonText: "Another user"
    
  }).then((result) => {
    if (result.isConfirmed) {
      transferToOppositeAccount(account_type, opposite)
    }else if (result.isDenied) {
      current_account.value = account_type;
      showEnterUsernameForTransModal.value = true;
      
    }
  });
};



const transferToOppositeAccount = (account_type, opposite) => {
  Swal.fire({
    title: 'Please wait',
    html: 'Getting current exchange rate.....',
    icon: 'info',
    showConfirmButton: false,
    allowEscapeKey: false,
    allowOutsideClick: false,
  });

  from_account.value = account_type;
  to_account.value = opposite;
  getCurrentExchangeRate();
}

const getCurrentExchangeRate = () => {
  if(!exhange_rate_form.processing){
    exhange_rate_form.post(route('wallet.exchange_rate'), {
      preserveScroll: true,
      onSuccess: (page) => {

        var response = page.props.flash.data;
        console.log(response)
        if (response.success && response.rate != 0.00){
          exchange_rate.value = response.rate;
          Swal.close();
          showTransfEnterAmtModal.value = true
        }else {
          getCurrentExchangeRate();
        }
          
      }, onError: (errors) => {
        getCurrentExchangeRate();
      },
      
    });
  }
}

const submitTransferToOtherAcctForm = () => {
  transfer_to_other_acct_form.from_account = from_account.value;
  transfer_to_other_acct_form.to_account = to_account.value;

  if(transfer_to_other_acct_form.from_account == "dollar"){
    var from_currency = "$";
  }else{
    var from_currency = "₦";
  }

  Swal.fire({
    title: 'Proceed?',
    html: `You are about to transfer ${from_currency}${mainStore.addCommas(transfer_to_other_acct_form.amount)} from your ${transfer_to_other_acct_form.from_account} account to your ${transfer_to_other_acct_form.to_account} account. <br> Do you wish to proceed? <br> <em class='text-primary-200'>Note: ${credited_text.value}</em>`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes Proceed!',
    cancelButtonText: "No Cancel"
    
  }).then((result) => {
    if (result.isConfirmed) {
      if(!transfer_to_other_acct_form.processing){
        transfer_to_other_acct_form.post(route('wallet.transfer_to_other_account'), {
          preserveScroll: true,
          onSuccess: (page) => {

            var response = page.props.flash.data;
            console.log(response)
            if (response.success){
              Swal.fire({
                title: 'Transfer Successful',
                html: `You have successfully transferred ${from_currency}${mainStore.addCommas(transfer_to_other_acct_form.amount)} from your ${transfer_to_other_acct_form.from_account} account to your ${transfer_to_other_acct_form.to_account} account.`,
                icon: 'success',
                
                allowEscapeKey: false,
                allowOutsideClick: false,
              }).then((result) => {
                if (result.isConfirmed) {
                  document.location.reload();
                }
              });
            }else {
              Swal.fire({
                title: 'Ooops!',
                html: `Something went wrong`,
                icon: 'error',
              });
            }
              
          }, onError: (errors) => {
            // Swal.fire({
            //   title: 'Ooops!',
            //   html: `Seems some errors occurred`,
            //   icon: 'error',
            // });
          },
          
        });
      }
    }
  });
}

const calcTransOtherAcctCred = () => {
  
  var amount = transfer_to_other_acct_form.amount;
  var rate = exchange_rate.value;
  var from = from_account.value;
  var to = to_account.value;
  

  if(amount == null || amount == ""){
    credited_text.value = "";
    return
  }

  if(to == "dollar"){
    var to_currency = "$";
  }else{
    var to_currency = "₦";
  }


  if(from == 'dollar'){
    var credited_amt = (amount * rate).toFixed(2);;
    credited_text.value = `You will be credited ${to_currency}${mainStore.addCommas(credited_amt)} on your local account`;
  }else{
    var credited_amt = (amount / rate).toFixed(2);;
    credited_text.value = `You will be credited ${to_currency}${mainStore.addCommas(credited_amt)} on your dollar account`;
  }

}

const showStatementDetail = (record_id) => {


  Swal.fire({
    title: 'Please wait',
    html: 'Getting statement details.....',
    icon: 'info',
    showConfirmButton: false,
    allowEscapeKey: false,
    allowOutsideClick: false,
  });

  statement_details_form.id = record_id
  if(!statement_details_form.processing){
    statement_details_form.post(route('wallet.statement_details'), {
      preserveScroll: true,
      onSuccess: (page) => {

        var response = page.props.flash.data;
        console.log(response)
        if (response.success && response.statement != []){
          statements_detail.value = response.statement;
          Swal.close();
          showStatementDetailModal.value = true;
        }else {
          Swal.fire({
            title: 'Ooops!',
            html: `Something went wrong`,
            icon: 'error',
          });
        }
          
      }, onError: (errors) => {
        Swal.fire({
          title: 'Ooops!',
          html: `Seems Something went wrong`,
          icon: 'error',
        });
      },
    });
  }
  

  

};

const submitTransferToOtherUserForm = () => {
  console.log(current_account.value)
  transfer_to_other_user_form.from_account = current_account.value;

  if(transfer_to_other_user_form.from_account == "dollar"){
    transfer_to_other_user_form.from_currency = "$";
  }else{
    transfer_to_other_user_form.from_currency = "₦";
  }

  // Swal.fire({
  //   title: 'Proceed?',
  //   html: `You are about to transfer ${from_currency}${mainStore.addCommas(transfer_to_other_user_form.amount)} from your ${transfer_to_other_user_form.from_account} account to user with username <em class='text-primary-200'>${transfer_to_other_user_form.user_name}</em>. <br> Do you wish to proceed?`,
  //   icon: 'warning',
  //   showCancelButton: true,
  //   confirmButtonColor: '#3085d6',
  //   cancelButtonColor: '#d33',
  //   confirmButtonText: 'Yes Proceed!',
  //   cancelButtonText: "No Cancel"
    
  // }).then((result) => {
  //   if (result.isConfirmed) {
      if(!transfer_to_other_user_form.processing){
        transfer_to_other_user_form.post(route('wallet.transfer_to_user'), {
          preserveScroll: true,
          onSuccess: (page) => {

            var response = page.props.flash.data;
            console.log(response)
            if (response.success && response.user_details != []) {
              var user_details = response.user_details
              recepient_details.value = user_details

              Swal.fire({
                title: 'Are These Details Correct',
                icon: 'warning',
                html: `<div class='grid grid-cols-12 gap-6'>

                  <h5 class='col-span-6 text-lg'>User Name: </h5> 
                    <h6 class='col-span-6 italic text-sm font-bold text-primary-100 capitalize'>${user_details.user_name}</h6> 
                    
                    <h5 class='col-span-6 text-lg'>Full Name: </h5> 
                    <h6 class='col-span-6 italic text-sm font-bold text-primary-100 capitalize'>${user_details.name}</h6> 

                    <h5 class='col-span-6 text-lg'>Email Address: </h5>
                    <h6 class='col-span-6 italic text-sm font-bold text-primary-100 lowercase'>${user_details.email}</h6> 
                    
                  </div>`,
                showCancelButton: true,
                confirmButtonText: 'Yes Proceed!',
              }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                  Swal.fire({
                    title: 'Proceed With Transfer?',
                    icon: 'question',
                    html: `Are You Sure You Want To Transfer <em class='text-primary-200'>${transfer_to_other_user_form.from_currency}${mainStore.addCommas(transfer_to_other_user_form.amount)}</em> To <em class='text-primary-200'>${user_details.name}</em> ?`,
                    showCancelButton: true,
                    confirmButtonText: 'Yes Proceed!',
                  }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                      showEnterUsernameForTransModal.value = false
                      showEnterPasswordTransferModal.value = true
                    }
                  });
                }
              });

            } else if (response.not_bouyant) {
              Swal.fire({
                title: 'Ooops!',
                html: "Sorry You Do Not Have Enough Funds For The Amount You Want To Transfer. Credit Your Account And Try Again",
                icon: 'error'
              });
            } 
            else if (response.recepient_does_not_exist) {
              Swal.fire({
                title: 'Ooops!',
                text: "Sorry This User Does Not Exist",
                icon: 'error'
              });
            } else if (response.recepient_is_self) {
              Swal.fire({
                title: 'Ooops!',
                text: "Sorry you cannot transfer to yourself",
                icon: 'error'
              });
            }else {
              Swal.fire({
                title: 'Ooops!',
                html: `Something went wrong`,
                icon: 'error',
              });
            }
              
          }, onError: (errors) => {
            var size = Object.keys(errors).length;
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: `There are ${size} form errors. Please fix them`,
            })
          },
          
        });
      }

      
  //   }
  // });
}

const submitEnterPasswordTransferForm = () => {
  if(!transfer_to_other_user_form.processing){
    transfer_to_other_user_form.post(route('wallet.verify_transfer_otp'), {
      preserveScroll: true,
      onSuccess: (page) => {
        console.log(page)
        var response = page.props.flash.data;
        console.log(response)

        if (response.success) {
        

          Swal.fire({
            title: 'Success',
            icon: 'success',
            html: `You Have Successfully Transferred <em class='text-primary-200'>${transfer_to_other_user_form.from_currency}${mainStore.addCommas(transfer_to_other_user_form.amount)} </em> to <em class='text-primary-200'> ${recepient_details.value.name} </em>`,
            allowEscapeKey: false,
            allowOutsideClick: false,
            
          }).then((result) => {
            document.location.reload()
            
          });

        } else if (response.not_bouyant) {
          Swal.fire({
            title: 'Ooops!',
            html: "Sorry You Do Not Have Enough Funds For The Amount You Want To Transfer. Credit Your Account And Try Again",
            icon: 'error'
          });
        }
        else if (response.recepient_does_not_exist) {
          Swal.fire({
            title: 'Ooops!',
            text: "Sorry This User Does Not Exist",
            icon: 'error'
          });
        } else if (response.recepient_is_self) {
          Swal.fire({
            title: 'Ooops!',
            text: "Sorry you cannot transfer to yourself",
            icon: 'error'
          });
        } else if (response.incorrect_password) {
          Swal.fire({
            title: 'Ooops!',
            text: "Password entered is incorrect!",
            icon: 'error'
          });
        } else {
          Swal.fire({
            title: 'Ooops!',
            text: "Sorry something went wrong",
            icon: 'error'
          });
        }

      }, onError: (errors) => {
        var size = Object.keys(errors).length;
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: `There are ${size} form errors. Please fix them`,
        })
      },
    });

  }
}


const creditAccount = (account_type) => {
  current_account_credit.value = account_type;

  if(current_account_credit.value == "dollar"){
    current_currency_credit.value = "$";
  }else{
    current_currency_credit.value = "₦";
  }

  
  

  // Swal.fire({
  //   title: 'Choose Action',
  //   html: `Choose credit method`,
  //   icon: 'question',
  //   showCancelButton: false,
  //   showDenyButton: true,
  //   confirmButtonColor: '#3085d6',
  //   denyButtonColor: '#059669',
  //   confirmButtonText: 'Customized payment account',
  //   denyButtonText: "Online payment"
    
  // }).then((result) => {
  //   if (result.isConfirmed) {
      showProvidusDetailsModal.value = true
  //   }else if (result.isDenied) {
  //     showEnterAmtForCreditModal.value = true
  //   }
  // });
}

const submitEnterAmtToCreditForm = () => {
  
  // showChoosePaymentOptionModal.value = true;
  

 if(current_account_credit.value == "dollar"){
  showEnterAmtForCreditModal.value = false;
  Swal.fire({
    title: 'Proceed with account credit',
    html: `<div class="">
        To credit your dollar wallet, transfer <em class="text-primary-200">$${ mainStore.addCommas(credit_account_form.amount) } </em> in USDT to the following wallet: <br> <br>
        <p class=" font-bold"><em class="text-primary-200"> ${ props.user.blockbee_address } </em></p>

        <p class=" text-sm font-bold mt-3">Click below to copy</p>


      </div>`,
    icon: 'success',
    confirmButtonText: 'Copy',
    
  }).then((result) => {
    
    navigator.clipboard.writeText(props.user.blockbee_address);
    // usePage().props.flash.success = "Link copied succcesfully"
  });
 }else{
    Swal.fire({
    title: 'Please wait',
    html: 'Getting payment details.....',
    icon: 'info',
    showConfirmButton: false,
    allowEscapeKey: false,
    allowOutsideClick: false,
  });

  
  getPaystackPaymentURL();
    
 }
}

const getPaystackPaymentURL = () => {
  if(!credit_account_form.processing){
    credit_account_form.post(route('wallet.paystack_payment_init'), {
      preserveScroll: true,
      onSuccess: (page) => {

        var response = page.props.flash.data;
        console.log(response)
        if (response.success && response.paystack_url != ""){
          paystack_url.value = response.paystack_url;
          Swal.close();
          showEnterAmtForCreditModal.value = false;
          showChoosePaymentOptionModal.value = true;
        }else {
          Swal.fire({
            title: 'Ooops!',
            html: `Something went wrong`,
            icon: 'error',
          });
        }
          
      }, onError: (errors) => {
        Swal.close();
        var size = Object.keys(errors).length;
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: `There are ${size} form errors. Please fix them`,
        })
      },
      
    });

  }
}

if (props.paystack_payment_made) {
  setTimeout(() => {
    Swal.fire({
      title: 'Payment Processing',
      html: "Your payment is currently being processed. You'll soon be credited",
      icon: 'success',
      allowEscapeKey: false,
      allowOutsideClick: false,
    }).then((result) => {
      if (result.isConfirmed) {
        router.visit(route('wallet.overview') + '?acct=naira');
      }
    });
  }, 1500);


}

const withdrawBtn = (account_type) => {
  console.log(account_type)
  
  if(account_type == "naira"){
    withdrawal_form.account_symbol = '₦';
    withdrawal_form.account_type = account_type;
    showWithdrawFundsModal.value = true;
  }else{
    
    dollar_withdrawal_form.account_symbol = '$';
    dollar_withdrawal_form.account_type = account_type;
    showWithdrawFundsDollarModal.value = true;
  }
};

const submitBankDetailsForm = () => {

  if(!withdrawal_form.processing){

    withdrawal_form.post(route('wallet.withdraw_funds_cont_naira'), {
      preserveScroll: true,
      onSuccess: (page) => {
        console.log(page)
        var response = page.props.flash.data;
        console.log(response)

        if (response.success && response.account_name != "") {
          var account_name = response.account_name
          withdrawal_form.account_name = account_name

          Swal.fire({
            title: 'Proceed With Withdrawal?',
            icon: 'success',
            html: `Is This Your Account Name <em class='text-primary-200'>${account_name}</em>?`,
            showCancelButton: true,
            confirmButtonText: 'Yes Proceed!',
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
              
              showWithdrawFundsModal.value = false
              showEnterWithdrawalAmtFormModal.value = true
                
            }
          });

        } else if (response.invalid_account) {
          Swal.fire({
            title: 'Invalid Account Details',
            html: "Sorry These Account Details Are Not Linked To Any Account",
            icon: 'error'
          });
        }
        else {
          Swal.fire({
            title: 'Ooops!',
            text: "Sorry something went wrong",
            icon: 'error'
          });
        }

      }, onError: (errors) => {
        var size = Object.keys(errors).length;
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: `There are ${size} form errors. Please fix them`,
        })
      },
    });
  }
}

const submitEnterAmountWithdrawalNairaForm = () => {


  if(!withdrawal_form.processing){
    withdrawal_form.post(route('wallet.enter_amount_withdraw_naira_funds'), {
      preserveScroll: true,
      onSuccess: (page) => {
        console.log(page)
        var response = page.props.flash.data;
        console.log(response)

        if (response.success && response.code != "" && response.phone_number != "") {
          

          Swal.fire({
            title: 'Proceed With Withdrawal?',
            icon: 'success',
            html: `Are You Sure You Want To Transfer <em class='text-primary-200'>₦ ${mainStore.addCommas(withdrawal_form.amount)}</em> From Your Digi Opulence Account To Bank Account With Account Name <em class='text-primary-200'>${withdrawal_form.account_name}</em>?`,
            showCancelButton: true,
            confirmButtonText: 'Yes Proceed!',
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {

              
              showEnterWithdrawalAmtFormModal.value = false
              showEnterPasswordWithdNairaModal.value = true
            }
          });

        } else if (response.not_referred_enough){
          var min_referrals = response.min_referrals
          var referrals_num = response.referrals_num
          var ref_referrals = min_referrals - referrals_num
          Swal.fire({
            title: 'Ooops!',
            html: `Sorry you have not referred enough members yet. You need to refer at least ${min_referrals} members to withdraw. You have currently referred ${referrals_num} Members. You have ${ref_referrals} more to go.`,
            icon: 'error'
          });
        } else if (response.not_bouyant) {
          Swal.fire({
            title: 'Ooops!',
            html: "Sorry You Do Not Have Enough Funds For The Amount You Want To Transfer. Credit Your Account And Try Again",
            icon: 'error'
          });
        }
        else if (response.too_small) {
          Swal.fire({
            title: 'Ooops!',
            
            text: `Minimum Withdrawable Amount Is ₦${mainStore.addCommas(props.min_withd_amt_naira)}`,
            icon: 'error'
          });
        } else {
          Swal.fire({
            title: 'Ooops!',
            text: "Sorry something went wrong",
            icon: 'error'
          });
        }

      }, onError: (errors) => {
        var size = Object.keys(errors).length;
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: `Sorry something went wrong`,
        })
      },
    });
  }
}

const submitEnterPasswordWithdNairaForm = () => {

  if(!withdrawal_form.processing){
    withdrawal_form.post(route('wallet.validate_withdrawal_naira_otp'), {
      preserveScroll: true,
      onSuccess: (page) => {
        console.log(page)
        var response = page.props.flash.data;
        console.log(response)

        if (response.success) {


          Swal.fire({
            title: 'Success',
            icon: 'success',
            html: `Your Request To Transfer <em class='text-primary-200'>₦${mainStore.addCommas(withdrawal_form.amount)}</em> From Your Digit Opulence Account To Bank Account With Name <em class='text-primary-200'>${withdrawal_form.account_name}</em> Has Been Sent To The Admin For Approval.`,
            allowEscapeKey: false,
            allowOutsideClick: false,

          }).then((result) => {
            document.location.reload()

          });

        } else if (response.incorrect_otp) {
          Swal.fire({
            title: 'Ooops!',
            html: "The Password Entered Is Incorrect. Please Enter The Valid One.",
            icon: 'error'
          });
        }
        else if (response.not_bouyant) {
          Swal.fire({
            title: 'Ooops!',
            text: "Sorry You Do Not Have Enough Funds For The Amount You Want To Transfer. Credit Your Account And Try Again",
            icon: 'error'
          });
        } else if (response.too_small) {
          Swal.fire({
            title: 'Ooops!',
            text: `Minimum Withdrawable Amount Is ₦${mainStore.addCommas(props.min_withd_amt_naira)}`,
            icon: 'error'
          });
        } else {
          Swal.fire({
            title: 'Ooops!',
            text: "Sorry something went wrong",
            icon: 'error'
          });
        }

      }, onError: (errors) => {
        var size = Object.keys(errors).length;
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: `There are ${size} form errors. Please fix them`,
        })
      },
    });
  }
}

const submitCryptoDetailsForm = () => {


  if(!dollar_withdrawal_form.processing){
    dollar_withdrawal_form.post(route('wallet.withdraw_funds_cont_dollar'), {
      preserveScroll: true,
      onSuccess: (page) => {
        console.log(page)
        var response = page.props.flash.data;
        console.log(response)

        if (response.success) {
          

          Swal.fire({
            title: 'Proceed With Withdrawal?',
            icon: 'question',
            html: `Crypto Wallet entered is <em class='text-primary-200'>${dollar_withdrawal_form.crypto_wallet}</em>. <br> Do you wish to proceed?`,
            showCancelButton: true,
            confirmButtonText: 'Yes Proceed!',
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
              
              showWithdrawFundsDollarModal.value = false
              showEnterWithdrawalAmtDollarFormModal.value = true
                
            }
          });

        } 
        else {
          Swal.fire({
            title: 'Ooops!',
            text: "Sorry something went wrong",
            icon: 'error'
          });
        }

      }, onError: (errors) => {
        var size = Object.keys(errors).length;
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: `There are ${size} form errors. Please fix them`,
        })
      },
    });
  }

}

const submitEnterAmountWithdrawalDollarForm = () => {


  if(!dollar_withdrawal_form.processing){
    dollar_withdrawal_form.post(route('wallet.enter_amount_withdraw_dollar_funds'), {
      preserveScroll: true,
      onSuccess: (page) => {
        console.log(page)
        var response = page.props.flash.data;
        console.log(response)

        if (response.success && response.code != "" && response.phone_number != "") {
          

          Swal.fire({
            title: 'Proceed With Withdrawal?',
            icon: 'question',
            html: `Are You Sure You Want To Transfer <em class='text-primary-200'>$${mainStore.addCommas(dollar_withdrawal_form.amount)}</em> From Your Digi Opulence Account To Crypto Wallet With Address <em class='text-primary-200'>${dollar_withdrawal_form.crypto_wallet}</em>?`,
            showCancelButton: true,
            confirmButtonText: 'Yes Proceed!',
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {

              
              showEnterWithdrawalAmtDollarFormModal.value = false
              showEnterPasswordWithdDollarModal.value = true
            }
          });

        } else if (response.not_referred_enough){
          var min_referrals = response.min_referrals
          var referrals_num = response.referrals_num
          var ref_referrals = min_referrals - referrals_num
          Swal.fire({
            title: 'Ooops!',
            html: `Sorry you have not referred enough members yet. You need to refer at least ${min_referrals} members to withdraw. You have currently referred ${referrals_num} Members. You have ${ref_referrals} more to go.`,
            icon: 'error'
          });
        } else if (response.not_bouyant) {
          Swal.fire({
            title: 'Ooops!',
            html: "Sorry You Do Not Have Enough Funds For The Amount You Want To Transfer. Credit Your Account And Try Again",
            icon: 'error'
          });
        }
        else if (response.too_small) {
          Swal.fire({
            title: 'Ooops!',
            
            text: `Minimum Withdrawable Amount Is $${mainStore.addCommas(props.min_withd_amt_dollar)}`,
            icon: 'error'
          });
        } else {
          Swal.fire({
            title: 'Ooops!',
            text: "Sorry something went wrong",
            icon: 'error'
          });
        }

      }, onError: (errors) => {
        var size = Object.keys(errors).length;
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: `Sorry something went wrong`,
        })
      },
    });
  }
}


const submitEnterPasswordWithdDollarForm = () => {
  if(!dollar_withdrawal_form.processing){
    dollar_withdrawal_form.post(route('wallet.validate_withdrawal_dollar_otp'), {
      preserveScroll: true,
      onSuccess: (page) => {
        console.log(page)
        var response = page.props.flash.data;
        console.log(response)

        if (response.success) {


          Swal.fire({
            title: 'Success',
            icon: 'success',
            html: `Your Request To Transfer <em class='text-primary-200'>₦${mainStore.addCommas(dollar_withdrawal_form.amount)}</em> From Your Digit Opulence Account To Crypto Wallet With Address  <em class='text-primary-200'>${dollar_withdrawal_form.crypto_wallet}</em> Has Been Sent To The Admin For Approval.`,
            allowEscapeKey: false,
            allowOutsideClick: false,

          }).then((result) => {
            document.location.reload()

          });

        } else if (response.incorrect_otp) {
          Swal.fire({
            title: 'Ooops!',
            html: "The Password Entered Is Incorrect. Please Enter The Valid One.",
            icon: 'error'
          });
        }
        else if (response.not_bouyant) {
          Swal.fire({
            title: 'Ooops!',
            text: "Sorry You Do Not Have Enough Funds For The Amount You Want To Transfer. Credit Your Account And Try Again",
            icon: 'error'
          });
        } else if (response.too_small) {
          Swal.fire({
            title: 'Ooops!',
            text: `Minimum Withdrawable Amount Is ₦${mainStore.addCommas(props.min_withd_amt_naira)}`,
            icon: 'error'
          });
        } else {
          Swal.fire({
            title: 'Ooops!',
            text: "Sorry something went wrong",
            icon: 'error'
          });
        }

      }, onError: (errors) => {
        var size = Object.keys(errors).length;
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: `There are ${size} form errors. Please fix them`,
        })
      },
    });
  }

}



const moreOptions = (account_type) => {
  more_options_account_type.value = account_type
  showMoreOptionsModal.value = true;
};
</script>

<template>
  <LayoutAuthenticated>

    <Head title="Wallet Overview" />
    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiWallet" title="Wallet Overview" main>
        <!-- <BaseButton
          href="https://github.com/justboil/admin-one-vue-tailwind"
          target="_blank"
          :icon="mdiGithub"
          label="Star on GitHub"
          color="contrast"
          rounded-full
          small
        /> -->
      </SectionTitleLineWithButton>


      <!-- <FlashMessages /> -->
      <CardBox class="w-full md:w-3/4 md:mx-auto mt-[40px]">
        <!-- <div class="grid grid-cols-12 gap-6">
          <div @click="tab_open = 1" :class="tab_open == 1 ? 'bg-gray-100' : ''" class="col-span-6 text-center  py-2 pt-4 px-3 rounded-md cursor-pointer transition ease-linear duration-300">
            
            <h4 class="dark:text-slate-600 text-4xl">Dollar</h4>
            <p class="dark:text-slate-600 mt-3 text-lg font-bold">Wallet</p>
            <div v-show="tab_open == 1" class="transition ease-linear duration-300 h-[5px] bg-primary-200 rounded-full w-full my-2 mt-4"></div>
          </div>

          <div @click="tab_open = 2" :class="tab_open == 2 ? 'bg-gray-100' : ''"
            class="col-span-6 text-center py-2 pt-4 px-3 rounded-md cursor-pointer transition ease-linear duration-300">

            <font-awesome-icon class="dark:text-slate-600 text-4xl" icon="fa-solid fa-naira-sign" />
            <h4 class="dark:text-slate-600 text-4xl">Local</h4>
            <p class="dark:text-slate-600 mt-3 text-lg font-bold">Account</p>
            <div v-show="tab_open == 2"
              class="transition ease-linear duration-300 h-[5px] bg-primary-200 rounded-full w-full my-2 mt-4"></div>
          </div>
        </div> -->

        <!-- <div v-show="tab_open == 1" class="px-3 mt-6 transition ease-linear duration-300">
          <span class="font-semibold text-lg">Total Balance</span>

          <h4 class="text-5xl font-bold mx-2 mt-1 mb-3" v-html="`$${mainStore.addCommas(user.dollar_wallet_balance)}`"></h4>

          

          <BaseButtons class="my-7">
            <BaseButton
              @click="creditAccount('dollar')"
              color="success"
              label="Credit"
              :small="true"
              :outline="false"
              :disabled="false"
              :rounded-full="true"
            />

            <BaseButton
              @click="transferBtn('dollar')"
              color="contrast"
              label="Transfer"
              :small="true"
              :outline="false"
              :disabled="false"
              :rounded-full="true"
            />

            <BaseButton
              @click="withdrawBtn('dollar')"
              color="info"
              label="Withdraw"
              :small="true"
              :outline="false"
              :disabled="false"
              :rounded-full="true"
            />
            

            <BaseButton
              :href="route('wallet.statement') + '?length=10&type=dollar&isDirty=1&__rememberable=1'"
              color="lightDark"
              label="Statement"
              :small="true"
              :outline="false"
              :disabled="false"
              :rounded-full="true"
            />

            <BaseButton
              @click="moreOptions('dollar')"
              color="contrast"
              label=""
              :icon="mdiDotsHorizontal"
              :small="true"
              :outline="true"
              :disabled="false"
              :rounded-full="true"
            />
            
            
          </BaseButtons>

          <BaseDivider />
          
          <div class=" my-4">
            <ul v-if="dollar_statement.length > 0" class="divide-y divide-gray-200">
              <li @click="showStatementDetail(record.id)" class="grid grid-cols-12 gap-6 py-2 cursor-pointer" v-for="(record, index) in dollar_statement" :key="index" >
                <div class="col-span-8">
                  <p class="text-sm font-bold">{{ record.summary }}</p>
                  <span class="text-gray-400 text-xs" v-html="`${record.date} ${record.time}`"></span>
                </div>

                <div class="col-span-4 ">
                  <div class="float-right text-sm font-semibold">
                    <span class="text-green-500" v-if="parseFloat(record.amount_after) > parseFloat(record.amount_before)">+</span>
                    <span class="text-red-500" v-else>-</span>
                    <span class=" " :class="parseFloat(record.amount_after) > parseFloat(record.amount_before) ? 'text-green-500' : 'text-red-500'"> ${{ mainStore.addCommas(record.amount) }}</span>
                  </div>
                </div>
              </li>
            </ul>

            <span v-else>No data here</span>
          </div>
        </div> -->

        <div v-show="tab_open == 2" class="px-3 mt-6 transition ease-linear duration-300">
          <span class="font-semibold text-lg">Total Balance</span>

          <h4 class="text-5xl font-bold mx-2 mt-1 mb-3"
            v-html="`₦${mainStore.addCommas((user.total_income - user.withdrawn).toFixed(2))}`">
          </h4>



          <BaseButtons class="my-7">
            <BaseButton @click="creditAccount('naira')" color="success" label="Credit" :small="true" :outline="false"
              :disabled="false" :rounded-full="true" />

            <BaseButton @click="router.visit(route('wallet.transfer'))" color="contrast" label="Transfer" :small="true"
              :outline="false" :disabled="false" :rounded-full="true" />

            <!-- <BaseButton @click="router.visit(route('wallet.withdrawal'))" color="info" label="Withdraw" :small="true"
              :outline="false" :disabled="false" :rounded-full="true" /> -->


            <BaseButton :href="route('wallet.statement') + '?length=10&type=naira&isDirty=1&__rememberable=1'"
              color="lightDark" label="Statement" :small="true" :outline="false" :disabled="false"
              :rounded-full="true" />

            <BaseButton @click="moreOptions('naira')" color="contrast" label="" :icon="mdiDotsHorizontal" :small="true"
              :outline="true" :disabled="false" :rounded-full="true" />



          </BaseButtons>

          <BaseDivider />

          <div class=" my-4">
            <ul v-if="statement.length > 0" class="divide-y divide-gray-200">

              <li @click="showStatementDetail(record.id)" class="grid grid-cols-12 gap-6 py-2 cursor-pointer"
                v-for="(record, index) in statement" :key="index">
                <div class="col-span-8">
                  <p class="text-sm font-bold">{{ record.summary }}</p>
                  <span class="text-gray-400 text-xs" v-html="`${record.date} ${record.time}`"></span>
                </div>

                <div class="col-span-4 ">
                  <div class="float-right text-sm font-semibold">
                    <span class="text-green-500"
                      v-if="parseFloat(record.amount_after) > parseFloat(record.amount_before)">+</span>
                    <span class="text-red-500" v-else>-</span>
                    <span class=""
                      :class="parseFloat(record.amount_after) > parseFloat(record.amount_before) ? 'text-green-500' : 'text-red-500'">
                      ₦{{ mainStore.addCommas(record.amount) }}</span>
                  </div>
                </div>
              </li>
            </ul>

            <!-- <span v-else>No data here</span> -->
          </div>
        </div>


      </CardBox>


    </SectionMain>



    <CardBoxModal v-model="showProvidusDetailsModal" button="danger" buttonLabel="Close"
      :title="`Personalized Account Funding`">

      <p class="my-3 text-emerald-500 italic font-bold">Funding less than ₦9000 is ₦25, while above ₦9000 cost ₦75 only.
      </p>


      <div class="">
        <table>

          <tbody>
            <tr>
              <td>Bank Name</td>
              <td>Providus Bank</td>
            </tr>
            <tr>
              <td>Account Name</td>
              <td class="text-bold italic text-sm text-primary">{{ user.providus_account_name }}</td>
            </tr>
            <tr>
              <td>Account Number</td>
              <td class="text-bold italic text-sm text-primary">{{ user.providus_account_number }}</td>
            </tr>
          </tbody>
        </table>

      </div>
    </CardBoxModal>



    <CardBoxModal v-model="showMoreOptionsModal" button="danger" buttonLabel="Close" :title="`More Links`">
      <!-- <p class="text-primary-200 italic font-semibold">Note: Withdrawal Comes With Charge Of ₦{{ mainStore.addCommas(withdrawal_charge_naira) }}</p> -->

      <ul class="divide-y divide-gray-200">
        <li
          @click="router.visit(route('wallet.credit_history') + '?length=10&type='+more_options_account_type+'&isDirty=1&__rememberable=1')"
          class="py-3  cursor-pointer">
          Wallet Credit History
        </li>
        <li
          @click="router.visit(route('wallet.transfer_history') + '?length=10&type='+more_options_account_type+'&isDirty=1&__rememberable=1')"
          class="py-3  cursor-pointer">
          Funds Transfer History
        </li>

        <!-- <li
          @click="router.visit(route('wallet.withdrawal_history') + '?length=10&type='+more_options_account_type+'&isDirty=1&__rememberable=1')"
          class="py-3  cursor-pointer">
          Withdrawal History
        </li> -->

        <li
          @click="router.visit(route('wallet.statement') + '?length=10&type='+more_options_account_type+'&isDirty=1&__rememberable=1')"
          class="py-3  cursor-pointer">
          Wallet Statement
        </li>
      </ul>
    </CardBoxModal>

    <CardBoxModal v-model="showEnterPasswordWithdDollarModal" button="danger" buttonLabel="Close"
      :title="`Enter your password to confirm withdrawal of $${mainStore.addCommas(dollar_withdrawal_form.amount)}`">
      <!-- <p class="text-primary-200 italic font-semibold">Note: Withdrawal Comes With Charge Of ₦{{ mainStore.addCommas(withdrawal_charge_naira) }}</p> -->

      <form @submit.prevent="submitEnterPasswordWithdDollarForm">


        <FormField class="w-full" :label="'Password: '">
          <FormControl class="w-full" v-model="dollar_withdrawal_form.passw" type="password" />

        </FormField>
        <span class="text-red-500 text-sm font-bold mb-3 italic">{{ dollar_withdrawal_form.errors.passw }}</span>

        <FormField class="w-full" label="Confirm Password">
          <FormControl class="w-full" v-model="dollar_withdrawal_form.passw_confirmation" type="password" />

        </FormField>
        <span class="text-red-500 text-sm font-bold mb-3 italic">{{ dollar_withdrawal_form.errors.passw_confirmation
          }}</span>

        <BaseButton :disabled="dollar_withdrawal_form.processing" type="submit" color="success" label="Submit"
          class="w-full" />
      </form>
    </CardBoxModal>

    <CardBoxModal v-model="showEnterWithdrawalAmtDollarFormModal" button="danger" buttonLabel="Close"
      :title="`Enter Withdrawal Amount To Proceed`">

      <!-- <p class="text-primary-200 italic font-semibold">Note: Withdrawal Comes With Charge Of ${{ mainStore.addCommas(withdrawal_charge_dollar) }}</p> -->


      <form @submit.prevent="submitEnterAmountWithdrawalDollarForm">
        <FormField label="Enter Amount">
          <FormControl v-model="dollar_withdrawal_form.amount" :icon="mdiAccountCash" type="number" />

        </FormField>

        <!-- <button :class="form.processing ? 'opacity-80 cursor-not-allowed' : ''" @mouseleave="btn_hovered = false"
          @mouseover="btn_hovered = true" type="submit" class="app-form-button">
          Submit
          <img v-if="form.processing" class="inline-block w-7 h-6 float-right"
            :src="btn_hovered ? FormLoaderDark : FormLoaderLight" alt="">
        </button> -->
        <BaseButton :disabled="dollar_withdrawal_form.processing" type="submit" color="success" label="Submit"
          class="w-full" />
      </form>
    </CardBoxModal>

    <CardBoxModal v-model="showWithdrawFundsDollarModal" button="danger" buttonLabel="Close"
      :title="`Enter Your Crypto Wallet Details`">

      <!-- <p class="text-primary-200 italic font-semibold">Note: Withdrawal Comes With Charge Of ${{ mainStore.addCommas(withdrawal_charge_dollar) }}</p> -->
      <p class="text-primary-200 italic font-semibold">Enter your USDT TRC 20 wallet address</p>


      <form @submit.prevent="submitCryptoDetailsForm">


        <FormField class="w-full" :label="'Enter wallet address'">
          <FormControl class="w-full" v-model="dollar_withdrawal_form.crypto_wallet" type="text" />

        </FormField>
        <span class="text-red-500 text-sm font-bold mb-3 italic">{{ dollar_withdrawal_form.errors.crypto_wallet
          }}</span>

        <BaseButton :disabled="dollar_withdrawal_form.processing" type="submit" color="success" label="Submit"
          class="w-full" />
      </form>

    </CardBoxModal>

    <CardBoxModal v-model="showEnterPasswordWithdNairaModal" button="danger" buttonLabel="Close"
      :title="`Enter your password to confirm withdrawal of ₦ ${mainStore.addCommas(withdrawal_form.amount)}`">
      <p class="text-primary-200 italic font-semibold">Note: Withdrawal Comes With Charge Of ₦{{
        mainStore.addCommas(withdrawal_charge) }}</p>

      <form @submit.prevent="submitEnterPasswordWithdNairaForm">


        <FormField class="w-full" :label="'Password: '">
          <FormControl class="w-full" v-model="withdrawal_form.passw" type="password" />

        </FormField>
        <span class="text-red-500 text-sm font-bold mb-3 italic">{{ withdrawal_form.errors.passw }}</span>

        <FormField class="w-full" label="Confirm Password">
          <FormControl class="w-full" v-model="withdrawal_form.passw_confirmation" type="password" />

        </FormField>
        <span class="text-red-500 text-sm font-bold mb-3 italic">{{ withdrawal_form.errors.passw_confirmation }}</span>

        <BaseButton :disabled="withdrawal_form.processing" type="submit" color="success" label="Submit"
          class="w-full" />
      </form>
    </CardBoxModal>

    <CardBoxModal v-model="showEnterWithdrawalAmtFormModal" button="danger" buttonLabel="Close"
      :title="`Enter Withdrawal Amount To Proceed`">

      <p class="text-primary-200 italic font-semibold">Note: Withdrawal Comes With Charge Of ₦{{
        mainStore.addCommas(withdrawal_charge) }}</p>


      <form @submit.prevent="submitEnterAmountWithdrawalNairaForm">
        <FormField label="Enter Amount">
          <FormControl v-model="withdrawal_form.amount" :icon="mdiAccountCash" type="number" />

        </FormField>

        <!-- <button :class="form.processing ? 'opacity-80 cursor-not-allowed' : ''" @mouseleave="btn_hovered = false"
          @mouseover="btn_hovered = true" type="submit" class="app-form-button">
          Submit
          <img v-if="form.processing" class="inline-block w-7 h-6 float-right"
            :src="btn_hovered ? FormLoaderDark : FormLoaderLight" alt="">
        </button> -->
        <BaseButton :disabled="withdrawal_form.processing" type="submit" color="success" label="Submit"
          class="w-full" />
      </form>
    </CardBoxModal>

    <CardBoxModal v-model="showWithdrawFundsModal" button="danger" buttonLabel="Close" :title="`Withdraw Funds`">

      <p class="text-primary-200 italic font-semibold">Note: Withdrawal Comes With Charge Of ₦{{
        mainStore.addCommas(withdrawal_charge) }}</p>

      <form @submit.prevent="submitBankDetailsForm" v-if="banks_arr.status && banks_arr.message == 'Banks retrieved'">
        <!-- <label for="bank_name" class="login-form-label">Select Bank Name: </label>
        <select class="col-span-4 mb-[7px]" id="bank_name" v-model="form.bank_name"
          :class="withdrawal_form.errors.bank_name ? 'login-form-input-error' : 'login-form-input'">
          <option v-for="row in banks_arr.data" :value="row.code" :key="row.id"
            v-html="`${row.name}`"></option>
        </select> -->

        <FormField label="Select Bank Name: ">
          <FormControl v-model="withdrawal_form.bank_name" :options="banks_arr.obj" />
        </FormField>
        <!-- <span class="login-form-error" v-if="withdrawal_form.errors.bank_name">{{ withdrawal_form.errors.bank_name }}</span> -->
        <!-- <span class="text-red-500 text-sm font-bold mb-3 italic">{{ withdrawal_form.errors.bank_name }}</span> -->


        <FormField class="w-full" :label="'Enter Account Number'">
          <FormControl class="w-full" v-model="withdrawal_form.account_number" type="number" />

        </FormField>
        <span class="text-red-500 text-sm font-bold mb-3 italic">{{ withdrawal_form.errors.account_number }}</span>

        <BaseButton :disabled="withdrawal_form.processing" type="submit" color="success" label="Submit"
          class="w-full" />
      </form>

    </CardBoxModal>


    <CardBoxModal v-model="showChoosePaymentOptionModal" button="danger" buttonLabel="Close"
      :title="`Proceed with account credit`">
      <FlashMessages />

      <div class="">


        <BaseButton :href="paystack_url" type="button" color="success" label="Click to proceed to payment page"
          class="w-full" />
      </div>

    </CardBoxModal>

    <CardBoxModal v-model="showEnterAmtForCreditModal" button="danger" buttonLabel="Close"
      :title="`Credit your account`">
      <FlashMessages />

      <div class="">


        <form @submit.prevent="submitEnterAmtToCreditForm" class="my-4">



          <FormField class="w-full"
            :label="current_account_credit == 'dollar' ? 'Enter amount in dollars' : 'Enter amount in naira' ">
            <FormControl class="w-full" v-model="credit_account_form.amount" type="number" step="any" />

          </FormField>
          <span class="text-red-500 text-sm font-bold mb-3 italic">{{ credit_account_form.errors.amount }}</span>

          <BaseButton :disabled="credit_account_form.processing" type="submit" color="success" label="Submit"
            class="w-full" />
        </form>
      </div>

    </CardBoxModal>


    <CardBoxModal v-model="showEnterPasswordTransferModal" button="danger" buttonLabel="Close"
      :title="`Enter your password to confirm transfer of ${transfer_to_other_user_form.from_currency}${mainStore.addCommas(transfer_to_other_user_form.amount)} to ${recepient_details.name} `">


      <form @submit.prevent="submitEnterPasswordTransferForm">


        <FormField class="w-full" :label="'Password: '">
          <FormControl class="w-full" v-model="transfer_to_other_user_form.passw" type="password" />

        </FormField>
        <span class="text-red-500 text-sm font-bold mb-3 italic">{{ transfer_to_other_user_form.errors.passw }}</span>

        <FormField class="w-full" label="Confirm Password">
          <FormControl class="w-full" v-model="transfer_to_other_user_form.passw_confirmation" type="password" />

        </FormField>
        <span class="text-red-500 text-sm font-bold mb-3 italic">{{
          transfer_to_other_user_form.errors.passw_confirmation }}</span>

        <BaseButton :disabled="transfer_to_other_user_form.processing" type="submit" color="success" label="Submit"
          class="w-full" />
      </form>
    </CardBoxModal>

    <CardBoxModal v-model="showEnterUsernameForTransModal" button="danger" buttonLabel="Close"
      :title="`Transfer funds to another user`">
      <FlashMessages />

      <div class="">


        <form @submit.prevent="submitTransferToOtherUserForm" class="my-4">

          <FormField class="w-full" :label="'Enter recepient user name: '">
            <FormControl class="w-full" v-model="transfer_to_other_user_form.user_name" type="text" />

          </FormField>
          <span class="text-red-500 text-sm font-bold mb-3 italic">{{ transfer_to_other_user_form.errors.user_name
            }}</span>

          <FormField class="w-full"
            :label="current_account == 'dollar' ? 'Enter amount in dollars: ' : 'Enter amount in naira: ' ">
            <FormControl class="w-full" v-model="transfer_to_other_user_form.amount" type="number" step="any" />

          </FormField>
          <span class="text-red-500 text-sm font-bold mb-3 italic">{{ transfer_to_other_user_form.errors.amount
            }}</span>

          <BaseButton :disabled="transfer_to_other_user_form.processing" type="submit" color="success" label="Submit"
            class="w-full" />
        </form>
      </div>

    </CardBoxModal>

    <CardBoxModal v-model="showTransfEnterAmtModal" button="danger" buttonLabel="Close"
      :title="`Transfer funds from your ${from_account} wallet to your ${to_account} wallet`">
      <FlashMessages />

      <div class="">
        <p class="font-semibold text-lg italic">Exchange Rate: <span class="text-primary-200"
            v-html="`₦${mainStore.addCommas(exchange_rate)} to 1 dollar`"></span> </p>

        <p class="font-semibold text-sm italic my-2">{{ credited_text }}</p>

        <form @submit.prevent="submitTransferToOtherAcctForm" class="my-4">
          <FormField class="w-full"
            :label="from_account == 'dollar' ? 'Enter amount in dollars: ' : 'Enter amount in naira: ' ">
            <FormControl @keyup="calcTransOtherAcctCred" class="w-full" v-model="transfer_to_other_acct_form.amount"
              type="number" step="any" />

          </FormField>
          <span class="text-red-500 text-sm font-bold mb-3 italic">{{ transfer_to_other_acct_form.errors.amount
            }}</span>

          <BaseButton type="submit" color="success" label="Submit" class="w-full" />
        </form>
      </div>

    </CardBoxModal>

    <CardBoxModal v-model="showStatementDetailModal" button="danger" buttonLabel="Close" :title="`More Details`">


      <div class="">
        <div class="grid grid-cols-12 gap-6">

          <h5 class="text-lg font-bold col-span-6">Summary </h5>
          <p class="text-sm  col-span-6">{{ statements_detail.summary }}</p>

          <h5 class="text-lg font-bold col-span-6">Account Type </h5>
          <p class="text-sm  col-span-6 capitalize">{{ statements_detail.type }}</p>

          <h5 class="text-lg font-bold col-span-6">Amount </h5>
          <p class="text-sm  col-span-6 capitalize"><span
              v-html="statements_detail.type == 'dollar' ? '$' : '₦' "></span>{{
            mainStore.addCommas(statements_detail.amount) }}</p>

          <h5 class="text-lg font-bold col-span-6">Transaction Type </h5>
          <p class="text-sm  col-span-6 capitalize"
            v-html="parseFloat(statements_detail.amount_after) > parseFloat(statements_detail.amount_before) ? 'Credit' : 'Debit'">
          </p>

          <h5 class="text-lg font-bold col-span-6">Amount Before </h5>
          <p class="text-sm  col-span-6 capitalize"><span
              v-html="statements_detail.type == 'dollar' ? '$' : '₦' "></span>{{
            mainStore.addCommas(statements_detail.amount_before) }}</p>

          <h5 class="text-lg font-bold col-span-6">Amount After </h5>
          <p class="text-sm  col-span-6 capitalize"><span
              v-html="statements_detail.type == 'dollar' ? '$' : '₦' "></span>{{
            mainStore.addCommas(statements_detail.amount_after) }}</p>

          <h5 class="text-lg font-bold col-span-6">Date / Time </h5>
          <p class="text-sm  col-span-6 capitalize">{{ statements_detail.date }}{{ statements_detail.time }}</p>

        </div>
      </div>



    </CardBoxModal>



  </LayoutAuthenticated>
</template>
