<?php
/**
 * Bank Statistics – SQL map
 * Base key => SQL template (use {{prefix}} for $wpdb->prefix).
 * The plugin will inject the table prefix, fix collations, and optionally add a date window.
 */
return [

/* ===================== MA (mobile app / internal) ===================== */

'ma_bisera' => <<<'SQL_MA_BISERA'
SELECT 
    SUM(CAST(m3.meta_value AS DECIMAL(10,2))) AS ma_bisera_amount_total,
    SUM(CAST(m4.meta_value AS DECIMAL(10,2))) AS ma_bisera_count_total,
    SUM(IF(m5.meta_value = 'приключен', CAST(m4.meta_value AS DECIMAL(10,2)), 0)) AS ma_bisera_status_success_total,
    SUM(IF(m5.meta_value != 'приключен', CAST(m4.meta_value AS DECIMAL(10,2)), 0)) AS ma_bisera_status_failed_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value LIKE '%OUT%'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'ini_reg1' AND m2.meta_value LIKE '%MBANK%'
JOIN {{prefix}}postmeta m6 ON p.ID = m6.post_id AND m6.meta_key = 'pay_system' AND m6.meta_value LIKE '%Bisera%'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'suma_bgn1'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'count'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'status';
SQL_MA_BISERA
,

'ma_swift' => <<<'SQL_MA_SWIFT'
SELECT 
    SUM(CAST(m3.meta_value AS DECIMAL(10,2))) AS ma_swift_amount_total,
    SUM(CAST(m4.meta_value AS DECIMAL(10,2))) AS ma_swift_count_total,
    SUM(IF(m5.meta_value = 'приключен', CAST(m4.meta_value AS DECIMAL(10,2)), 0)) AS ma_swift_status_success_total,
    SUM(IF(m5.meta_value != 'приключен', CAST(m4.meta_value AS DECIMAL(10,2)), 0)) AS ma_swift_status_failed_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value LIKE '%OUT%'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'ini_reg1' AND m2.meta_value LIKE '%MBANK%'
JOIN {{prefix}}postmeta m6 ON p.ID = m6.post_id AND m6.meta_key = 'pay_system' AND m6.meta_value LIKE '%SWIFT%'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'suma_eur1'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'count'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'status';
SQL_MA_SWIFT
,

'ma_sepa_credit' => <<<'SQL_MA_SEPA_CREDIT'
SELECT 
    SUM(CAST(m3.meta_value AS DECIMAL(10,2))) AS ma_sepa_credit_amount_total,
    SUM(CAST(m4.meta_value AS DECIMAL(10,2))) AS ma_sepa_credit_count_total,
    SUM(IF(m5.meta_value = 'приключен', CAST(m4.meta_value AS DECIMAL(10,2)), 0)) AS ma_sepa_credit_status_success_total,
    SUM(IF(m5.meta_value != 'приключен', CAST(m4.meta_value AS DECIMAL(10,2)), 0)) AS ma_sepa_credit_status_failed_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value LIKE '%OUT%'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'ini_reg1' AND m2.meta_value LIKE '%MBANK%'
JOIN {{prefix}}postmeta m6 ON p.ID = m6.post_id AND m6.meta_key = 'pay_system' AND m6.meta_value LIKE '%STEP2/CENTROlink%'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'suma_org'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'count'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'status';
SQL_MA_SEPA_CREDIT
,

'ma_target_2' => <<<'SQL_MA_TARGET_2'
SELECT 
    SUM(CAST(m3.meta_value AS DECIMAL(10,2))) AS ma_target_2_amount_total,
    SUM(CAST(m4.meta_value AS DECIMAL(10,2))) AS ma_target_2_count_total,
    SUM(IF(m5.meta_value = 'приключен', CAST(m4.meta_value AS DECIMAL(10,2)), 0)) AS ma_target_2_status_success_total,
    SUM(IF(m5.meta_value != 'приключен', CAST(m4.meta_value AS DECIMAL(10,2)), 0)) AS ma_target_2_status_failed_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value LIKE '%OUT%'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'ini_reg1' AND m2.meta_value LIKE '%MBANK%'
JOIN {{prefix}}postmeta m6 ON p.ID = m6.post_id AND m6.meta_key = 'pay_system' AND m6.meta_value LIKE '%TARGET2%'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'suma_eur1'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'count'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'status';
SQL_MA_TARGET_2
,

'ma_sepa_instant' => <<<'SQL_MA_SEPA_INSTANT'
SELECT 
    SUM(CAST(m3.meta_value AS DECIMAL(10,2))) AS ma_sepa_instant_amount_total,
    SUM(CAST(m4.meta_value AS DECIMAL(10,2))) AS ma_sepa_instant_count_total,
    SUM(IF(m5.meta_value = 'приключен', CAST(m4.meta_value AS DECIMAL(10,2)), 0)) AS ma_sepa_instant_status_success_total,
    SUM(IF(m5.meta_value != 'приключен', CAST(m4.meta_value AS DECIMAL(10,2)), 0)) AS ma_sepa_instant_status_failed_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value LIKE '%OUT%'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'ini_reg1' AND m2.meta_value LIKE '%MBANK%'
JOIN {{prefix}}postmeta m6 ON p.ID = m6.post_id AND m6.meta_key = 'pay_system' AND m6.meta_value LIKE '%RT1/Instant%'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'suma_eur1'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'count'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'status';
SQL_MA_SEPA_INSTANT
,

'ma_blink' => <<<'SQL_MA_BLINK'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS ma_blink_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS ma_blink_count_total,
    SUM(IF(m4.meta_value = 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS ma_blink_status_success_total,
    SUM(IF(m4.meta_value != 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS ma_blink_status_failed_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value LIKE '%OUT%'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_bgn1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'ini_reg1' AND m5.meta_value LIKE '%MBANK%'
JOIN {{prefix}}postmeta m6 ON p.ID = m6.post_id AND m6.meta_key = 'pay_system' AND m6.meta_value LIKE '%BLINK%';
SQL_MA_BLINK
,

'ma_rings' => <<<'SQL_MA_RINGS'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS ma_rings_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS ma_rings_count_total,
    SUM(IF(m4.meta_value = 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS ma_rings_status_success_total,
    SUM(IF(m4.meta_value != 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS ma_rings_status_failed_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value LIKE '%OUT%'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_bgn1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'ini_reg1' AND m5.meta_value LIKE '%MBANK%'
JOIN {{prefix}}postmeta m6 ON p.ID = m6.post_id AND m6.meta_key = 'pay_system' AND m6.meta_value LIKE '%RINGS%';
SQL_MA_RINGS
,

'ma_intrabank' => <<<'SQL_MA_INTRABANK'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS ma_intrabank_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS ma_intrabank_count_total,
    SUM(IF(m4.meta_value = 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS ma_intrabank_status_success_total,
    SUM(IF(m4.meta_value != 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS ma_intrabank_status_failed_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value LIKE '%OUT%'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_bgn1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'ini_reg1' AND m5.meta_value LIKE '%MBANK%'
JOIN {{prefix}}postmeta m6 ON p.ID = m6.post_id AND m6.meta_key = 'pay_system' AND m6.meta_value LIKE '%Intrabank%';
SQL_MA_INTRABANK
,

'ma_topup' => <<<'SQL_MA_TOPUP'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS ma_topup_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS ma_topup_count_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value LIKE '%INNER%'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_bgn1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'ini_reg1' AND m4.meta_value LIKE '%FOS%'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'ECONOMIC_SECTOR' AND m5.meta_value LIKE '%2000%';
SQL_MA_TOPUP
,

'ma_utility' => <<<'SQL_MA_UTILITY'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS ma_utility_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS ma_utility_count_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value LIKE '%INNER%'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_bgn1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'ini_reg1' AND m4.meta_value LIKE '%FOS%'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'ECONOMIC_SECTOR' AND m5.meta_value LIKE '%1000%';
SQL_MA_UTILITY
,

'ma_blink_p2p' => <<<'SQL_MA_BLINK_P2P'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS ma_blink_p2p_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS ma_blink_p2p_count_total,
    SUM(IF(m4.meta_value = 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS ma_blink_p2p_status_success_total,
    SUM(IF(m4.meta_value != 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS ma_blink_p2p_status_failed_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value LIKE '%OUT%'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_bgn1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'ini_reg1' AND m5.meta_value LIKE '%MBANK%'
JOIN {{prefix}}postmeta m6 ON p.ID = m6.post_id AND m6.meta_key = 'pay_system' AND m6.meta_value LIKE '%Blink P2P%';
SQL_MA_BLINK_P2P
,

'ma_loan_repayment' => <<<'SQL_MA_LOAN_REPAYMENT'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS ma_loan_repayment_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS ma_loan_repayment_count_total,
    SUM(IF(m4.meta_value = 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS ma_loan_repayment_status_success_total,
    SUM(IF(m4.meta_value != 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS ma_loan_repayment_status_failed_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value LIKE '%INNER%'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_bgn1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'ini_reg1' AND m5.meta_value LIKE '%FOS%'
JOIN {{prefix}}postmeta m6 ON p.ID = m6.post_id AND m6.meta_key = 'pay_system' AND m6.meta_value LIKE '%Loan repayment%';
SQL_MA_LOAN_REPAYMENT
,

'ma_tbi_p2p' => <<<'SQL_MA_TBI_P2P'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS ma_tbi_p2p_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS ma_tbi_p2p_count_total,
    SUM(IF(m4.meta_value = 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS ma_tbi_p2p_status_success_total,
    SUM(IF(m4.meta_value != 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS ma_tbi_p2p_status_failed_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value LIKE '%OUT%'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_bgn1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'ini_reg1' AND m5.meta_value LIKE '%MBANK%'
JOIN {{prefix}}postmeta m6 ON p.ID = m6.post_id AND m6.meta_key = 'pay_system' AND m6.meta_value LIKE '%TBI P2P%';
SQL_MA_TBI_P2P
,

/* ===================== Merchant ===================== */

'merchant_bisera' => <<<'SQL_MERCHANT_BISERA'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS merchant_bisera_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS merchant_bisera_count_total,
    SUM(IF(m4.meta_value = 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS merchant_bisera_status_success_total,
    SUM(IF(m4.meta_value != 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS merchant_bisera_status_failed_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value LIKE '%OUT%'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_bgn1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'ini_reg1' AND m5.meta_value LIKE '%RBCT%'
JOIN {{prefix}}postmeta m6 ON p.ID = m6.post_id AND m6.meta_key = 'pay_system' AND m6.meta_value LIKE '%Bisera%';
SQL_MERCHANT_BISERA
,

'merchant_rings' => <<<'SQL_MERCHANT_RINGS'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(10,2))) AS merchant_rings_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(10,2))) AS merchant_rings_count_total,
    SUM(IF(m4.meta_value = 'приключен', CAST(m3.meta_value AS DECIMAL(10,2)), 0)) AS merchant_rings_status_success_total,
    SUM(IF(m4.meta_value != 'приключен', CAST(m3.meta_value AS DECIMAL(10,2)), 0)) AS merchant_rings_status_failed_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value LIKE '%OUT%'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_bgn1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'ini_reg1' AND m5.meta_value LIKE '%RBCT%'
JOIN {{prefix}}postmeta m6 ON p.ID = m6.post_id AND m6.meta_key = 'pay_system' AND m6.meta_value LIKE '%RINGS%';
SQL_MERCHANT_RINGS
,

'merchant_intrabank' => <<<'SQL_MERCHANT_INTRABANK'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS merchant_intrabank_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS merchant_intrabank_count_total,
    SUM(IF(m4.meta_value = 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS merchant_intrabank_status_success_total,
    SUM(IF(m4.meta_value != 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS merchant_intrabank_status_failed_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value LIKE '%OUT%'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_bgn1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'ini_reg1' AND m5.meta_value LIKE '%RBCT%'
JOIN {{prefix}}postmeta m6 ON p.ID = m6.post_id AND m6.meta_key = 'pay_system' AND m6.meta_value LIKE '%Intrabank%';
SQL_MERCHANT_INTRABANK
,

/* ===================== Payment Hub ===================== */

'payment_hub_intrabank' => <<<'SQL_PAYMENT_HUB_INTRABANK'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS payment_hub_intrabank_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS payment_hub_intrabank_count_total,
    SUM(IF(m4.meta_value = 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS payment_hub_intrabank_status_success_total,
    SUM(IF(m4.meta_value != 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS payment_hub_intrabank_status_failed_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value = 'OUT'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_bgn1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status' AND m4.meta_value LIKE '%приключен%'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'ini_reg1' 
JOIN {{prefix}}postmeta m6 ON p.ID = m6.post_id AND m6.meta_key = 'pay_system' AND m6.meta_value LIKE '%Intrabank%'
WHERE m5.meta_value IN ('MBANK','FBANK','CIBS','RBCT','PHCAS','O2PAY','PH4FS','PHCS2','PHFL3','TBIGR','PHCSU','PH4OY','PH4FL','PHSVL','PHSOL','PH4F2','PHVIV','PHFL2','FOS','EBANK');
SQL_PAYMENT_HUB_INTRABANK
,

'payment_hub_blink' => <<<'SQL_PAYMENT_HUB_BLINK'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS payment_hub_blink_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS payment_hub_blink_count_total,
    SUM(IF(m4.meta_value = 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS payment_hub_blink_status_success_total,
    SUM(IF(m4.meta_value != 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS payment_hub_blink_status_failed_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value LIKE '%OUT%'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_bgn1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'pay_system' AND m5.meta_value LIKE '%Blink%'
JOIN {{prefix}}postmeta m6 ON p.ID = m6.post_id AND m6.meta_key = 'ini_reg1' AND (LOWER(m6.meta_value) LIKE '%phviv%' OR m6.meta_value LIKE '%PHCIT%');
SQL_PAYMENT_HUB_BLINK
,

'payment_hub_sepa_instant' => <<<'SQL_PAYMENT_HUB_SEPA_INSTANT'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS payment_hub_sepa_instant_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS payment_hub_sepa_instant_count_total,
    SUM(IF(m4.meta_value = 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS payment_hub_sepa_instant_status_success_total,
    SUM(IF(m4.meta_value != 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS payment_hub_sepa_instant_status_failed_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value = 'OUT'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_eur1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status' AND m4.meta_value LIKE '%приключен%'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'ini_reg1' 
JOIN {{prefix}}postmeta m6 ON p.ID = m6.post_id AND m6.meta_key = 'pay_system' AND m6.meta_value LIKE '%RT1/Instant%'
WHERE m5.meta_value IN ('MBANK','FBANK','CIBS','RBCT','PHCAS','O2PAY','PH4FS','PHCS2','PHFL3','TBIGR','PHCSU','PH4OY','PH4FL','PHSVL','PHSOL','PH4F2','PHVIV','PHFL2','FOS','EBANK');
SQL_PAYMENT_HUB_SEPA_INSTANT
,

'payment_hub_bisera' => <<<'SQL_PAYMENT_HUB_BISERA'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS payment_hub_bisera_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS payment_hub_bisera_count_total,
    SUM(IF(m4.meta_value = 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS payment_hub_bisera_status_success_total,
    SUM(IF(m4.meta_value != 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS payment_hub_bisera_status_failed_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value = 'OUT'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_bgn1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status' AND m4.meta_value LIKE '%приключен%'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'ini_reg1' 
JOIN {{prefix}}postmeta m6 ON p.ID = m6.post_id AND m6.meta_key = 'pay_system' AND m6.meta_value LIKE '%Bisera%'
WHERE m5.meta_value IN ('MBANK','FBANK','CIBS','RBCT','PHCAS','O2PAY','PH4FS','PHCS2','PHFL3','TBIGR','PHCSU','PH4OY','PH4FL','PHSVL','PHSOL','PH4F2','PHVIV','PHFL2','FOS','EBANK');
SQL_PAYMENT_HUB_BISERA
,

/* ===================== Incoming ===================== */

'incoming_swift' => <<<'SQL_INCOMING_SWIFT'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS incoming_swift_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS incoming_swift_count_total,
    SUM(IF(m4.meta_value = 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS incoming_swift_status_success_total,
    SUM(IF(m4.meta_value != 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS incoming_swift_status_failed_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value LIKE '%IN%'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_eur1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'pay_system' AND m5.meta_value LIKE '%SWIFT%';
SQL_INCOMING_SWIFT
,

'incoming_target_2' => <<<'SQL_INCOMING_TARGET_2'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS incoming_target_2_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS incoming_target_2_count_total,
    SUM(IF(m4.meta_value = 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS incoming_target_2_status_success_total,
    SUM(IF(m4.meta_value != 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS incoming_target_2_status_failed_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value LIKE '%IN%'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_eur1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'pay_system' AND m5.meta_value LIKE '%TARGET2%';
SQL_INCOMING_TARGET_2
,

'incoming_sepa_credit' => <<<'SQL_INCOMING_SEPA_CREDIT'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS incoming_sepa_credit_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS incoming_sepa_credit_count_total,
    SUM(IF(m4.meta_value = 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS incoming_sepa_credit_status_success_total,
    SUM(IF(m4.meta_value != 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS incoming_sepa_credit_status_failed_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value LIKE '%IN%'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_org'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'pay_system' AND m5.meta_value LIKE '%STEP2/CENTROlink%';
SQL_INCOMING_SEPA_CREDIT
,

'incoming_sepa_instant' => <<<'SQL_INCOMING_SEPA_INSTANT'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS incoming_sepa_instant_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS incoming_sepa_instant_count_total,
    SUM(IF(m4.meta_value = 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS incoming_sepa_instant_status_success_total,
    SUM(IF(m4.meta_value != 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS incoming_sepa_instant_status_failed_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value LIKE '%IN%'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_eur1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'pay_system' AND m5.meta_value LIKE '%RT1/Instant%';
SQL_INCOMING_SEPA_INSTANT
,

'incoming_blink' => <<<'SQL_INCOMING_BLINK'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS incoming_blink_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS incoming_blink_count_total,
    SUM(IF(m4.meta_value = 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS incoming_blink_status_success_total,
    SUM(IF(m4.meta_value != 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS incoming_blink_status_failed_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value LIKE '%IN%'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_bgn1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'pay_system' AND m5.meta_value LIKE '%BLINK%';
SQL_INCOMING_BLINK
,

'incoming_bisera' => <<<'SQL_INCOMING_BISERA'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS incoming_bisera_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS incoming_bisera_count_total,
    SUM(IF(m4.meta_value = 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS incoming_bisera_status_success_total,
    SUM(IF(m4.meta_value != 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS incoming_bisera_status_failed_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value LIKE '%IN%'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_bgn1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'pay_system' AND m5.meta_value LIKE '%Bisera%';
SQL_INCOMING_BISERA
,

'incoming_intrabank' => <<<'SQL_INCOMING_INTRABANK'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS incoming_intrabank_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS incoming_intrabank_count_total,
    SUM(IF(m4.meta_value = 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS incoming_intrabank_status_success_total,
    SUM(IF(m4.meta_value != 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS incoming_intrabank_status_failed_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value LIKE '%IN%'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_bgn1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'pay_system' AND m5.meta_value LIKE '%Intrabank%';
SQL_INCOMING_INTRABANK
,

'incoming_rings' => <<<'SQL_INCOMING_RINGS'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS incoming_rings_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS incoming_rings_count_total,
    SUM(IF(m4.meta_value = 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS incoming_rings_status_success_total,
    SUM(IF(m4.meta_value != 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS incoming_rings_status_failed_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value LIKE '%IN%'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_bgn1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'pay_system' AND m5.meta_value LIKE '%RINGS%';
SQL_INCOMING_RINGS
,

/* ===================== Outgoing ===================== */

'outgoing_swift' => <<<'SQL_OUTGOING_SWIFT'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS outgoing_swift_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS outgoing_swift_count_total,
    SUM(IF(m4.meta_value = 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS outgoing_swift_status_success_total,
    SUM(IF(m4.meta_value != 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS outgoing_swift_status_failed_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value LIKE '%OUT%'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_eur1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'pay_system' AND m5.meta_value LIKE '%SWIFT%';
SQL_OUTGOING_SWIFT
,

'outgoing_target_2' => <<<'SQL_OUTGOING_TARGET_2'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS outgoing_target_2_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS outgoing_target_2_count_total,
    SUM(IF(m4.meta_value = 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS outgoing_target_2_status_success_total,
    SUM(IF(m4.meta_value != 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS outgoing_target_2_status_failed_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value LIKE '%OUT%'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_eur1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'pay_system' AND m5.meta_value LIKE '%TARGET2%';
SQL_OUTGOING_TARGET_2
,

'outgoing_sepa_credit' => <<<'SQL_OUTGOING_SEPA_CREDIT'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS outgoing_sepa_credit_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS outgoing_sepa_credit_count_total,
    SUM(IF(m4.meta_value = 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS outgoing_sepa_credit_status_success_total,
    SUM(IF(m4.meta_value != 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS outgoing_sepa_credit_status_failed_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value LIKE '%OUT%'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_org'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'pay_system' AND m5.meta_value LIKE '%STEP2/CENTROlink%';
SQL_OUTGOING_SEPA_CREDIT
,

'outgoing_sepa_instant' => <<<'SQL_OUTGOING_SEPA_INSTANT'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS outgoing_sepa_instant_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS outgoing_sepa_instant_count_total,
    SUM(IF(m4.meta_value = 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS outgoing_sepa_instant_status_success_total,
    SUM(IF(m4.meta_value != 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS outgoing_sepa_instant_status_failed_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value LIKE '%OUT%'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_eur1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'pay_system' AND m5.meta_value LIKE '%RT1/Instant%';
SQL_OUTGOING_SEPA_INSTANT
,

'outgoing_blink' => <<<'SQL_OUTGOING_BLINK'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS outgoing_blink_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS outgoing_blink_count_total,
    SUM(IF(m4.meta_value = 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS outgoing_blink_status_success_total,
    SUM(IF(m4.meta_value != 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS outgoing_blink_status_failed_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value LIKE '%OUT%'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_bgn1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'pay_system' AND m5.meta_value LIKE '%BLINK%';
SQL_OUTGOING_BLINK
,

'outgoing_bisera' => <<<'SQL_OUTGOING_BISERA'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS outgoing_bisera_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS outgoing_bisera_count_total,
    SUM(IF(m4.meta_value = 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS outgoing_bisera_status_success_total,
    SUM(IF(m4.meta_value != 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS outgoing_bisera_status_failed_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value LIKE '%OUT%'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_bgn1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'pay_system' AND m5.meta_value LIKE '%Bisera%';
SQL_OUTGOING_BISERA
,

'outgoing_intrabank' => <<<'SQL_OUTGOING_INTRABANK'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS outgoing_intrabank_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS outgoing_intrabank_count_total,
    SUM(IF(m4.meta_value = 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS outgoing_intrabank_status_success_total,
    SUM(IF(m4.meta_value != 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS outgoing_intrabank_status_failed_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value LIKE '%OUT%'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_bgn1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'pay_system' AND m5.meta_value LIKE '%Intrabank%';
SQL_OUTGOING_INTRABANK
,

/* ---- NEW: outgoing_rings (including failed_total alias fix) ---- */
'outgoing_rings' => <<<'SQL_OUTGOING_RINGS'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS outgoing_rings_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS outgoing_rings_count_total,
    SUM(IF(m4.meta_value = 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS outgoing_rings_status_success_total,
    SUM(IF(m4.meta_value != 'приключен', CAST(m3.meta_value AS DECIMAL(12,2)), 0)) AS outgoing_rings_status_failed_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value LIKE '%OUT%'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_bgn1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'pay_system' AND m5.meta_value LIKE '%RINGS%';
SQL_OUTGOING_RINGS
,

/* ===================== Online (PH*) ===================== */

'online_intrabank' => <<<'SQL_ONLINE_INTRABANK'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS online_intrabank_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS online_intrabank_count_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value = 'OUT'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_bgn1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status' AND m4.meta_value LIKE '%приключен%'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'ini_reg1' 
JOIN {{prefix}}postmeta m6 ON p.ID = m6.post_id AND m6.meta_key = 'pay_system' AND m6.meta_value LIKE '%Intrabank%'
WHERE m5.meta_value IN ('MBANK','FBANK','CIBS','RBCT','PHCAS','O2PAY','PH4FS','PHCS2','PHFL3','TBIGR','PHCSU','PH4OY','PH4FL','PHSVL','PHSOL','PH4F2','PHVIV','PHFL2','FOS','EBANK');
SQL_ONLINE_INTRABANK
,

'online_bisera' => <<<'SQL_ONLINE_BISERA'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS online_bisera_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS online_bisera_count_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value = 'OUT'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_bgn1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status' AND m4.meta_value LIKE '%приключен%'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'ini_reg1' 
JOIN {{prefix}}postmeta m6 ON p.ID = m6.post_id AND m6.meta_key = 'pay_system' AND m6.meta_value LIKE '%Bisera%'
WHERE m5.meta_value IN ('MBANK','FBANK','CIBS','RBCT','PHCAS','O2PAY','PH4FS','PHCS2','PHFL3','TBIGR','PHCSU','PH4OY','PH4FL','PHSVL','PHSOL','PH4F2','PHVIV','PHFL2','FOS','EBANK');
SQL_ONLINE_BISERA
,

'online_sepa_instant' => <<<'SQL_ONLINE_SEPA_INSTANT'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS online_sepa_instant_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS online_sepa_instant_count_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value = 'OUT'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_eur1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status' AND m4.meta_value LIKE '%приключен%'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'ini_reg1' 
JOIN {{prefix}}postmeta m6 ON p.ID = m6.post_id AND m6.meta_key = 'pay_system' AND m6.meta_value LIKE '%RT1/Instant%'
WHERE m5.meta_value IN ('MBANK','FBANK','CIBS','RBCT','PHCAS','O2PAY','PH4FS','PHCS2','PHFL3','TBIGR','PHCSU','PH4OY','PH4FL','PHSVL','PHSOL','PH4F2','PHVIV','PHFL2','FOS','EBANK');
SQL_ONLINE_SEPA_INSTANT
,

'online_rings' => <<<'SQL_ONLINE_RINGS'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS online_rings_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS online_rings_count_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value = 'OUT'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_bgn1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status' AND m4.meta_value LIKE '%приключен%'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'ini_reg1' 
JOIN {{prefix}}postmeta m6 ON p.ID = m6.post_id AND m6.meta_key = 'pay_system' AND m6.meta_value LIKE '%RINGS%'
WHERE m5.meta_value IN ('MBANK','FBANK','CIBS','RBCT','PHCAS','O2PAY','PH4FS','PHCS2','PHFL3','TBIGR','PHCSU','PH4OY','PH4FL','PHSVL','PHSOL','PH4F2','PHVIV','PHFL2','FOS','EBANK');
SQL_ONLINE_RINGS
,

'online_swift' => <<<'SQL_ONLINE_SWIFT'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS online_swift_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS online_swift_count_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value = 'OUT'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_eur1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status' AND m4.meta_value LIKE '%приключен%'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'ini_reg1' 
JOIN {{prefix}}postmeta m6 ON p.ID = m6.post_id AND m6.meta_key = 'pay_system' AND m6.meta_value LIKE '%SWIFT%'
WHERE m5.meta_value IN ('MBANK','FBANK','CIBS','RBCT','PHCAS','O2PAY','PH4FS','PHCS2','PHFL3','TBIGR','PHCSU','PH4OY','PH4FL','PHSVL','PHSOL','PH4F2','PHVIV','PHFL2','FOS','EBANK');
SQL_ONLINE_SWIFT
,

'online_target_2' => <<<'SQL_ONLINE_TARGET_2'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS online_target_2_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS online_target_2_count_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value = 'OUT'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_eur1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status' AND m4.meta_value LIKE '%приключен%'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'ini_reg1' 
JOIN {{prefix}}postmeta m6 ON p.ID = m6.post_id AND m6.meta_key = 'pay_system' AND m6.meta_value LIKE '%TARGET2%'
WHERE m5.meta_value IN ('MBANK','FBANK','CIBS','RBCT','PHCAS','O2PAY','PH4FS','PHCS2','PHFL3','TBIGR','PHCSU','PH4OY','PH4FL','PHSVL','PHSOL','PH4F2','PHVIV','PHFL2','FOS','EBANK');
SQL_ONLINE_TARGET_2
,

'online_sepa_credit' => <<<'SQL_ONLINE_SEPA_CREDIT'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS online_sepa_credit_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS online_sepa_credit_count_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value = 'OUT'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_org'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status' AND m4.meta_value LIKE '%приключен%'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'ini_reg1' 
JOIN {{prefix}}postmeta m6 ON p.ID = m6.post_id AND m6.meta_key = 'pay_system' AND m6.meta_value LIKE '%STEP2/CENTROlink%'
WHERE m5.meta_value IN ('MBANK','FBANK','CIBS','RBCT','PHCAS','O2PAY','PH4FS','PHCS2','PHFL3','TBIGR','PHCSU','PH4OY','PH4FL','PHSVL','PHSOL','PH4F2','PHVIV','PHFL2','FOS','EBANK');
SQL_ONLINE_SEPA_CREDIT
,

'online_blink' => <<<'SQL_ONLINE_BLINK'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS online_blink_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS online_blink_count_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value = 'OUT'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_bgn1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status' AND m4.meta_value LIKE '%приключен%'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'ini_reg1' 
JOIN {{prefix}}postmeta m6 ON p.ID = m6.post_id AND m6.meta_key = 'pay_system' AND m6.meta_value LIKE '%BLINK%'
WHERE m5.meta_value IN ('MBANK','FBANK','CIBS','RBCT','PHCAS','O2PAY','PH4FS','PHCS2','PHFL3','TBIGR','PHCSU','PH4OY','PH4FL','PHSVL','PHSOL','PH4F2','PHVIV','PHFL2','FOS','EBANK');
SQL_ONLINE_BLINK
,

/* ===================== Offline ===================== */

'offline_swift' => <<<'SQL_OFFLINE_SWIFT'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS offline_swift_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS offline_swift_count_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value = 'OUT'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_eur1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status' AND m4.meta_value LIKE '%приключен%'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'ini_reg1' 
JOIN {{prefix}}postmeta m6 ON p.ID = m6.post_id AND m6.meta_key = 'pay_system' AND m6.meta_value LIKE '%SWIFT%'
WHERE m5.meta_value NOT IN ('MBANK','FBANK','CIBS','RBCT','PHCAS','O2PAY','PH4FS','PHCS2','PHFL3','TBIGR','PHCSU','PH4OY','PH4FL','PHSVL','PHSOL','PH4F2','PHVIV','PHFL2','FOS','EBANK');
SQL_OFFLINE_SWIFT
,

'offline_sepa_credit' => <<<'SQL_OFFLINE_SEPA_CREDIT'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS offline_sepa_credit_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS offline_sepa_credit_count_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value = 'OUT'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_org'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status' AND m4.meta_value LIKE '%приключен%'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'ini_reg1' 
JOIN {{prefix}}postmeta m6 ON p.ID = m6.post_id AND m6.meta_key = 'pay_system' AND m6.meta_value LIKE '%STEP2/CENTROlink%'
WHERE m5.meta_value NOT IN ('MBANK','FBANK','CIBS','RBCT','PHCAS','O2PAY','PH4FS','PHCS2','PHFL3','TBIGR','PHCSU','PH4OY','PH4FL','PHSVL','PHSOL','PH4F2','PHVIV','PHFL2','FOS','EBANK');
SQL_OFFLINE_SEPA_CREDIT
,

'offline_target_2' => <<<'SQL_OFFLINE_TARGET_2'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS offline_target_2_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS offline_target_2_count_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value = 'OUT'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_eur1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status' AND m4.meta_value LIKE '%приключен%'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'ini_reg1' 
JOIN {{prefix}}postmeta m6 ON p.ID = m6.post_id AND m6.meta_key = 'pay_system' AND m6.meta_value LIKE '%TARGET2%'
WHERE m5.meta_value NOT IN ('MBANK','FBANK','CIBS','RBCT','PHCAS','O2PAY','PH4FS','PHCS2','PHFL3','TBIGR','PHCSU','PH4OY','PH4FL','PHSVL','PHSOL','PH4F2','PHVIV','PHFL2','FOS','EBANK');
SQL_OFFLINE_TARGET_2
,

'offline_rings' => <<<'SQL_OFFLINE_RINGS'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS offline_rings_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS offline_rings_count_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value = 'OUT'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_bgn1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status' AND m4.meta_value LIKE '%приключен%'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'ini_reg1' 
JOIN {{prefix}}postmeta m6 ON p.ID = m6.post_id AND m6.meta_key = 'pay_system' AND m6.meta_value LIKE '%RINGS%'
WHERE m5.meta_value NOT IN ('MBANK','FBANK','CIBS','RBCT','PHCAS','O2PAY','PH4FS','PHCS2','PHFL3','TBIGR','PHCSU','PH4OY','PH4FL','PHSVL','PHSOL','PH4F2','PHVIV','PHFL2','FOS','EBANK');
SQL_OFFLINE_RINGS
,

'offline_bisera' => <<<'SQL_OFFLINE_BISERA'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS offline_bisera_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS offline_bisera_count_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value = 'OUT'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_bgn1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status' AND m4.meta_value LIKE '%приключен%'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'ini_reg1' 
JOIN {{prefix}}postmeta m6 ON p.ID = m6.post_id AND m6.meta_key = 'pay_system' AND m6.meta_value LIKE '%Bisera%'
WHERE m5.meta_value NOT IN ('MBANK','FBANK','CIBS','RBCT','PHCAS','O2PAY','PH4FS','PHCS2','PHFL3','TBIGR','PHCSU','PH4OY','PH4FL','PHSVL','PHSOL','PH4F2','PHVIV','PHFL2','FOS','EBANK');
SQL_OFFLINE_BISERA
,

'offline_intrabank' => <<<'SQL_OFFLINE_INTRABANK'
SELECT 
    SUM(CAST(m2.meta_value AS DECIMAL(12,2))) AS offline_intrabank_amount_total,
    SUM(CAST(m3.meta_value AS DECIMAL(12,2))) AS offline_intrabank_count_total
FROM {{prefix}}posts p
JOIN {{prefix}}postmeta m1 ON p.ID = m1.post_id AND m1.meta_key = 'in_out' AND m1.meta_value = 'OUT'
JOIN {{prefix}}postmeta m2 ON p.ID = m2.post_id AND m2.meta_key = 'suma_bgn1'
JOIN {{prefix}}postmeta m3 ON p.ID = m3.post_id AND m3.meta_key = 'count'
JOIN {{prefix}}postmeta m4 ON p.ID = m4.post_id AND m4.meta_key = 'status' AND m4.meta_value LIKE '%приключен%'
JOIN {{prefix}}postmeta m5 ON p.ID = m5.post_id AND m5.meta_key = 'ini_reg1' 
JOIN {{prefix}}postmeta m6 ON p.ID = m6.post_id AND m6.meta_key = 'pay_system' AND m6.meta_value LIKE '%Intrabank%'
WHERE m5.meta_value NOT IN ('MBANK','FBANK','CIBS','RBCT','PHCAS','O2PAY','PH4FS','PHCS2','PHFL3','TBIGR','PHCSU','PH4OY','PH4FL','PHSVL','PHSOL','PH4F2','PHVIV','PHFL2','FOS','EBANK');
SQL_OFFLINE_INTRABANK
,

];
