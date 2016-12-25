<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mail
 *
 * @author HOME
 */
class Mail extends CI_Model{
    private $username='topchatcustomercare@gmail.com';
    private $password='topchat123';
    private $port='465';
    function sendMail($array){
        $this->email->clear(TRUE);
        $config['protocol'] = "smtp";
        $config['smtp_host'] = "ssl://smtp.gmail.com";
        $config['smtp_port'] = $this->port;
        $config['smtp_user'] = $this->username; 
        $config['smtp_pass'] =$this->password;
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
         $config['mailtype'] = "html";
$this->email->initialize($config);
        
        $this->email->from($this->username);
            $this->email->to($array['to']);
           $this->email->cc($array['cc']);
        
        $this->email->subject($array['subject']);
        $this->email->message($array['message']);
        $this->email->send();
        
    }
    function generateOrderMail($cart_id=null){
        $array['body']=$this->newOrderTemplate($cart_id);
         $cart_record=$this->db->query("select * from tbl_cart_master cm inner join tbl_customer_address_master  cam on cm.billing_address_id=cam.id where cart_id='$cart_id'")->row();
        $array['email']='adityalohiya23@gmail.com'; 
        $array['subject']="Your Order has Successfully Placed";
        $array['message']=$this->newOrderTemplate($cart_id);
        $array['cc']=array('topchat'=>'topchatcustomercare@gmail.com');
        $array['to']=array($cart_record->customer_name =>$cart_record->email);
        $this->sendMail($array);
    }
    private function newOrderTemplate($cart_id){
        $cart_record=$this->db->query("select *,(select name from tbl_user_master where id=cm.order_by) as name from tbl_cart_master cm inner join tbl_customer_address_master  cam on cm.billing_address_id=cam.id where cart_id='$cart_id'")->row();
        $find=array('[#IMAGE_LINK#]','[#CUSTOMER_NAME#]','[#CUSTOMER_CARE_EMAIL#]','[#ORDER_ID#]','[#ORDER_TIME#]','[#BILLING_NAME#]','[#BILLING_ADDRESS#]');
        $replace=array(
                        base_url()."asset/web/images/logo.png",
                        $cart_record->name,
                        $this->username,
                        $cart_record->order_id,
                        Date('d-M-Y h:i:s a',strtotime($cart_record->order_date)),
                        $cart_record->customer_name,
                        $cart_record->address."<br/>".$cart_record->city."<br/>".$cart_record->state,
                        );
        $html='<table cellspacing="0" cellpadding="0" width="100%">
              
                  <tr>
                     <td valign="top"><a><img alt="TOPCHAT"  src="[#IMAGE_LINK#]" style="margin-bottom:10px" border="0" style="width:60px;height:60px"></a></td>
                  </tr>
                  
                  <tr>
                     <td valign="top">
                        <h1 style="font-size:22px;font-weight:normal;line-height:22px;margin:0 0 11px 0">
                        Hello, [#CUSTOMER_NAME#]
                        </h1>
                        <p style="font-size:12px;line-height:16px;margin-top:10px">
                           Thank you for your order from TopChat.
                           Once your package ships we will send an email with a link to track your order.
                           You can check the status of your order by <a style="color:#1e7ec8">logging into your account</a>.
                           If you have any questions about your order please contact us at <a style="color:#1e7ec8">[#CUSTOMER_CARE_EMAIL#]</a> 
                        </p>
                        <p style="font-size:12px;line-height:16px;margin-top:10px">Your order confirmation is below. Thank you again for your business.
                        </p>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <h2 style="font-size:18px;font-weight:normal;margin:0">
                        Your Order [#ORDER_ID#] <small>(placed on [#ORDER_TIME#])</small>
                        </h2>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <table cellspacing="0" cellpadding="0" border="0" width="650">
                           <thead>
                              <tr>
                                 <th align="left" width="325" bgcolor="#EAEAEA" style="font-size:13px;padding:5px 9px 6px 9px;line-height:1em">Billing Information:</th>
                                 <th width="10"></th>
                                 <th align="left" width="325" bgcolor="#EAEAEA" style="font-size:13px;padding:5px 9px 6px 9px;line-height:1em">Payment Method:</th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr>
                                 <td valign="top" style="font-size:12px;padding:7px 9px 9px 9px;border-left:1px solid #eaeaea;border-bottom:1px solid #eaeaea;border-right:1px solid #eaeaea">
                                [#BILLING_NAME#]
                                 <br>
                                 [#BILLING_ADDRESS#]
                                 </td>
                                 <td></td>
                                 <td valign="top" style="font-size:12px;padding:7px 9px 9px 9px;border-left:1px solid #eaeaea;border-bottom:1px solid #eaeaea;border-right:1px solid #eaeaea">
                                 <b>Cash On Delivery</b>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                        <br>
                       
                        <table cellspacing="0" cellpadding="0" border="0" width="650">
                           <thead>
                              <tr>
                                 <th align="left" width="325" bgcolor="#EAEAEA" style="font-size:13px;padding:5px 9px 6px 9px;line-height:1em">Shipping Information:</th>
                                 <th width="10"></th>
                           
                              </tr>
                           </thead>
                           <tbody>
                              <tr>
                                 <td valign="top" style="font-size:12px;padding:7px 9px 9px 9px;border-left:1px solid #eaeaea;border-bottom:1px solid #eaeaea;border-right:1px solid #eaeaea">
                                [#BILLING_NAME#]<br>
                                [#BILLING_ADDRESS#]
                                 </td>
                                 <td></td>
                                 
                              </tr>
                           </tbody>
                        </table>
                        <br>';
             $html=str_replace($find,$replace,$html);           
             $html.='<table width="650" cellspacing="0" cellpadding="0" border="0" style="border:1px solid #eaeaea">
                           <tbody>
                              <tr>
                                 <th bgcolor="#eaeaea" align="left" style="font-size:13px;padding:3px 9px"> Item Name</th>
                                 
                                 <th bgcolor="#eaeaea" align="left" style="font-size:13px;padding:3px 9px"> Qty</th>
                                 <th bgcolor="#eaeaea" align="left" style="font-size:13px;padding:3px 9px">Subtotal</th>
                              </tr>
                           </tbody>
                           <tbody bgcolor="#f6f6f6">';
               $cart_item_result=$this->db->query("select * from tbl_cart_item where cart_id='$cart_record->cart_id'")->result();
               foreach($cart_item_result as $cartitemrecord){
                 $html.='<tr>
                              <td align="left" style="padding:3px 9px;border-bottom:1px dotted #ccc;font-size:11px">'.
                              $cartitemrecord->item_desc
                              .'</td>
                              <td align="left" style="padding:3px 9px;border-bottom:1px dotted #ccc;font-size:11px">
                             '.$cartitemrecord->qty.'
                              </td>
                              <td align="left" style="padding:3px 9px;border-bottom:1px dotted #ccc;font-size:11px">
                               '.$cartitemrecord->total_gross_price.'
                              </td>
                              </tr>';
               }
                   $html.= '</tbody>
                           <tbody>
                              <tr>
                                 <td align="right" style="padding:3px 9px;font-size:11px" colspan="3">
                                 SubTotal
                                 </td>
                                 <td align="left" style="padding:3px 9px;font-size:11px">
                                 '.$cart_record->total_cost.'
                                 </td>
                              </tr>';
                   $total_amount = $cart_record->total_cost;
                   $taxresult = $this->db->query("SELECT * FROM `tbl_cart_tax_map` where cart_id='$cart_record->cart_id' ")->result();
                    foreach ($taxresult as $taxrecord) {
                                    $total_amount = ($total_amount * $taxrecord->tax_value) / 100 + $total_amount;
                    $html.= '<tr>
                                 <td align="right" style="padding:3px 9px;font-size:11px" colspan="3">'.$taxrecord->tax_title.'</td>
                                 <td align="left" style="padding:3px 9px;font-size:11px">'.$taxrecord->tax_value.'%</td>
                        
                  </tr>';
                    }
                    $shippingrecord = $this->db->query("select * from tbl_shipping_rule_master where currency_id=1")->row();
                                        if (isset($shippingrecord->min_value)) {
                                            if ($cart_record->total_cost > $shippingrecord->min_value) {
                                                 $shipping_charge='NA';
                                            } else {
                                                $total_amount = $total_amount + $shippingrecord->shipping_charge;
                                                $shipping_charge=$shippingrecord->shipping_charge;
                                            }
                   }
                    $html.= '<tr>
                                 <td align="right" style="padding:3px 9px;font-size:11px" colspan="3">Shipping Charges</td>
                                 <td align="left" style="padding:3px 9px;font-size:11px">'.$shipping_charge.'</td>
                              </tr>
                              <tr><td align="right" style="padding:3px 9px;font-size:11px" colspan="3">
                              <b>Grand Total Price</b>
                              </td>
                              <td align="left" style="padding:3px 9px;font-size:11px">
                              <b>'.$total_amount.'</b>
                              </td>
                              </tr>
                           </tbody>
                        </table>
                        <p style="font-size:12px;margin:0 0 10px 0"></p>
                     </td>
                  </tr>';
                  $html.='<tr>
                     <td bgcolor="#EAEAEA" align="center" style="background:#eaeaea;text-align:center">
                        <center>
                           <p style="font-size:12px;margin:0">Thank you, 
                           <strong>TopChat</strong>
                           </p>
                        </center>
                     </td>
                  </tr>
               </tbody>
            </table>
            </td>
            </tr>
            </tbody></table>
        

';
             return $html;
    }
    //put your code here
}

?>
