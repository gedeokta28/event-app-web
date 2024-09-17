<?php

namespace App\Helpers;

final class OrderStatus
{

    const ORDER_CREATED = 'created';
    const ORDER_COMPLETE = 'completed';
    const PAYMENT_PENDING = 'payment_pending';
    const PROCESSING = 'processing';
    const HOLD_ON = 'hold_on';
    const ORDER_CANCELLED = 'cancelled';
    const ON_DELIVERY = 'on_delivery';


    public static function getOrderNotifMessage(string $orderStatus): string
    {
        if ($orderStatus === self::ORDER_CREATED) {
            return 'Pesanan anda terdaftar kedalam sistem, kami akan segera memproses pesanan anda.';
        }

        if ($orderStatus === self::ORDER_COMPLETE) {
            return 'Status pesanan anda telah selesai. Terima kasih sudah berbelanja di tempat kami.';
        }

        if ($orderStatus === self::PAYMENT_PENDING) {
            return 'Status pesanan anda menunggu proses pembayaran. Mohon segera lakukan pembayaran sesuai nominal yang tertera. Terima kasih.';
        }

        if ($orderStatus === self::PROCESSING) {
            return 'Status pesanan anda sedang kami proses mohon menunggu. Terima kasih.';
        }

        if ($orderStatus === self::HOLD_ON) {
            return 'Status pesanan anda sedang kami proses mohon menunggu. Terima kasih.';
        }

        if ($orderStatus === self::ON_DELIVERY) {
            return 'Status pesanan anda sedang dalam pengiriman mohon menunggu. Terima kasih.';
        }

        if ($orderStatus === self::ORDER_CANCELLED) {
            return 'Status pesanan anda dibatalkan oleh sistem.';
        }
    }

    public static function getOrderActionStatus(string $orderStatus): string
    {
        if ($orderStatus === self::ORDER_CREATED) {
            return 'ORDER_CREATED';
        }

        if ($orderStatus === self::ORDER_COMPLETE) {
            return 'ORDER_COMPELETED';
        }

        if ($orderStatus === self::PAYMENT_PENDING) {
            return 'PAYMENT_PENDING';
        }

        if ($orderStatus === self::PROCESSING) {
            return 'PROCESSING';
        }

        if ($orderStatus === self::HOLD_ON) {
            return 'HOLD_ON';
        }

        if ($orderStatus === self::ON_DELIVERY) {
            return 'ON_DELIVERY';
        }

        if ($orderStatus === self::ORDER_CANCELLED) {
            return 'ORDER_CANCELLED';
        }
    }

    public static function getOrderStatusForHuman(string $orderStatus): string
    {
        if ($orderStatus === self::ORDER_CREATED) {
            return 'Order Created';
        }

        if ($orderStatus === self::ORDER_COMPLETE) {
            return 'Order Completed';
        }

        if ($orderStatus === self::PAYMENT_PENDING) {
            return 'Payment Pending';
        }

        if ($orderStatus === self::PROCESSING) {
            return 'Processing';
        }

        if ($orderStatus === self::HOLD_ON) {
            return 'Hold On';
        }

        if ($orderStatus === self::ON_DELIVERY) {
            return 'On Delivery';
        }

        if ($orderStatus === self::ORDER_CANCELLED) {
            return 'Order Cancelled';
        }
    }
}
