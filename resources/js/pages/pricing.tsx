import React, { useState } from 'react';
import { Head, Link } from '@inertiajs/react';

interface SubscriptionPlan {
    id: number;
    name: string;
    slug: string;
    description: string;
    price_monthly: number;
    price_yearly: number;
    credits_monthly: number;
    features: string[];
    max_team_members: number;
    is_popular: boolean;
    formatted_monthly_price: string;
    formatted_yearly_price: string;
    yearly_savings_percentage: number;
}

interface Props {
    plans: SubscriptionPlan[];
    [key: string]: unknown;
}

export default function Pricing({ plans }: Props) {
    const [isYearly, setIsYearly] = useState(false);

    const getButtonText = (plan: SubscriptionPlan) => {
        if (plan.slug === 'free') {
            return '🚀 Mulai Gratis';
        }
        return '💳 Pilih Paket';
    };

    const getButtonVariant = (plan: SubscriptionPlan) => {
        if (plan.is_popular) {
            return 'bg-gradient-to-r from-blue-600 to-green-600 hover:from-blue-700 hover:to-green-700 text-white';
        }
        if (plan.slug === 'free') {
            return 'bg-gray-600 hover:bg-gray-700 text-white';
        }
        return 'border-2 border-blue-600 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20';
    };

    return (
        <>
            <Head title="Harga - KontenLokal AI" />
            
            <div className="min-h-screen bg-gray-50 dark:bg-gray-900">
                {/* Header */}
                <div className="bg-white dark:bg-gray-800 shadow-sm border-b">
                    <div className="container mx-auto px-4 py-6">
                        <div className="text-center">
                            <h1 className="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                                💰 Paket Berlangganan
                            </h1>
                            <p className="text-lg text-gray-600 dark:text-gray-300">
                                Pilih paket yang sesuai dengan kebutuhan bisnis Anda
                            </p>
                        </div>
                    </div>
                </div>

                <div className="container mx-auto px-4 py-12">
                    {/* Billing Toggle */}
                    <div className="flex justify-center mb-12">
                        <div className="bg-white dark:bg-gray-800 p-1 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                            <div className="flex items-center">
                                <button
                                    onClick={() => setIsYearly(false)}
                                    className={`px-6 py-2 rounded-lg text-sm font-medium transition-all ${
                                        !isYearly
                                            ? 'bg-blue-600 text-white shadow-sm'
                                            : 'text-gray-600 dark:text-gray-300 hover:text-blue-600'
                                    }`}
                                >
                                    Bulanan
                                </button>
                                <button
                                    onClick={() => setIsYearly(true)}
                                    className={`px-6 py-2 rounded-lg text-sm font-medium transition-all ${
                                        isYearly
                                            ? 'bg-blue-600 text-white shadow-sm'
                                            : 'text-gray-600 dark:text-gray-300 hover:text-blue-600'
                                    }`}
                                >
                                    Tahunan
                                    <span className="ml-2 bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">
                                        Hemat hingga 17%
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>

                    {/* Pricing Cards */}
                    <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6 max-w-7xl mx-auto">
                        {plans.map((plan) => (
                            <div
                                key={plan.id}
                                className={`relative bg-white dark:bg-gray-800 rounded-2xl shadow-lg border-2 transition-all hover:shadow-xl ${
                                    plan.is_popular
                                        ? 'border-blue-500 transform scale-105'
                                        : 'border-gray-200 dark:border-gray-700'
                                }`}
                            >
                                {/* Popular Badge */}
                                {plan.is_popular && (
                                    <div className="absolute -top-4 left-1/2 transform -translate-x-1/2">
                                        <span className="bg-gradient-to-r from-blue-600 to-green-600 text-white px-4 py-1 rounded-full text-sm font-medium">
                                            ⭐ Paling Populer
                                        </span>
                                    </div>
                                )}

                                <div className="p-6">
                                    {/* Plan Header */}
                                    <div className="text-center mb-6">
                                        <h3 className="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                                            {plan.name}
                                        </h3>
                                        <p className="text-gray-600 dark:text-gray-300 text-sm">
                                            {plan.description}
                                        </p>
                                    </div>

                                    {/* Pricing */}
                                    <div className="text-center mb-6">
                                        <div className="flex items-baseline justify-center">
                                            <span className="text-4xl font-bold text-gray-900 dark:text-white">
                                                {isYearly ? (
                                                    plan.price_yearly === 0 ? 'Gratis' : 
                                                    `Rp ${Math.round(plan.price_yearly / 12 / 1000)}k`
                                                ) : (
                                                    plan.price_monthly === 0 ? 'Gratis' : 
                                                    `Rp ${Math.round(plan.price_monthly / 1000)}k`
                                                )}
                                            </span>
                                            {plan.price_monthly > 0 && (
                                                <span className="text-gray-500 dark:text-gray-400 ml-1">
                                                    /bulan
                                                </span>
                                            )}
                                        </div>
                                        
                                        {isYearly && plan.yearly_savings_percentage > 0 && (
                                            <div className="mt-2">
                                                <span className="text-green-600 text-sm font-medium">
                                                    Hemat {plan.yearly_savings_percentage}% dengan paket tahunan!
                                                </span>
                                            </div>
                                        )}
                                        
                                        <div className="mt-3 text-sm text-gray-600 dark:text-gray-300">
                                            <strong>{plan.credits_monthly}</strong> kredit per bulan
                                        </div>
                                    </div>

                                    {/* Features */}
                                    <div className="space-y-3 mb-8">
                                        <h4 className="font-semibold text-gray-900 dark:text-white text-sm">
                                            Fitur termasuk:
                                        </h4>
                                        <ul className="space-y-2">
                                            {plan.features.map((feature, index) => (
                                                <li key={index} className="flex items-start space-x-2 text-sm">
                                                    <span className="text-green-500 mt-0.5">✓</span>
                                                    <span className="text-gray-600 dark:text-gray-300">{feature}</span>
                                                </li>
                                            ))}
                                        </ul>
                                        
                                        <div className="pt-2 text-xs text-gray-500 dark:text-gray-400">
                                            Hingga <strong>{plan.max_team_members}</strong> anggota tim
                                        </div>
                                    </div>

                                    {/* CTA Button */}
                                    <div className="text-center">
                                        {plan.slug === 'free' ? (
                                            <Link
                                                href={route('register')}
                                                className={`block w-full py-3 px-4 rounded-xl font-semibold transition-all ${getButtonVariant(plan)}`}
                                            >
                                                {getButtonText(plan)}
                                            </Link>
                                        ) : (
                                            <button
                                                className={`block w-full py-3 px-4 rounded-xl font-semibold transition-all ${getButtonVariant(plan)}`}
                                                onClick={() => alert('Integrasi payment gateway sedang dalam pengembangan!')}
                                            >
                                                {getButtonText(plan)}
                                            </button>
                                        )}
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>

                    {/* FAQ Section */}
                    <div className="max-w-4xl mx-auto mt-20">
                        <h2 className="text-3xl font-bold text-center text-gray-900 dark:text-white mb-12">
                            🤔 Pertanyaan Umum
                        </h2>
                        
                        <div className="grid md:grid-cols-2 gap-8">
                            <div className="space-y-6">
                                <div>
                                    <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                        Apa itu kredit?
                                    </h3>
                                    <p className="text-gray-600 dark:text-gray-300 text-sm">
                                        Kredit adalah mata uang dalam platform kami. Setiap jenis konten membutuhkan kredit tertentu untuk dihasilkan. Misalnya, script TikTok membutuhkan 2 kredit, sedangkan email marketing hanya 1 kredit.
                                    </p>
                                </div>
                                
                                <div>
                                    <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                        Bagaimana cara upgrade paket?
                                    </h3>
                                    <p className="text-gray-600 dark:text-gray-300 text-sm">
                                        Anda bisa upgrade paket kapan saja melalui dashboard. Kredit yang belum terpakai akan tetap tersimpan dan ditambahkan dengan kredit paket baru.
                                    </p>
                                </div>
                                
                                <div>
                                    <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                        Apakah ada trial period?
                                    </h3>
                                    <p className="text-gray-600 dark:text-gray-300 text-sm">
                                        Ya! Paket Free memberikan 20 kredit gratis setiap bulan tanpa perlu kartu kredit. Anda bisa mencoba semua fitur platform kami.
                                    </p>
                                </div>
                            </div>
                            
                            <div className="space-y-6">
                                <div>
                                    <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                        Metode pembayaran apa saja yang diterima?
                                    </h3>
                                    <p className="text-gray-600 dark:text-gray-300 text-sm">
                                        Kami menerima semua metode pembayaran lokal Indonesia melalui Midtrans: transfer bank, e-wallet (GoPay, OVO, DANA), dan kartu kredit/debit.
                                    </p>
                                </div>
                                
                                <div>
                                    <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                        Bisakah cancel subscription?
                                    </h3>
                                    <p className="text-gray-600 dark:text-gray-300 text-sm">
                                        Tentu saja! Anda bisa cancel subscription kapan saja. Kredit yang tersisa akan tetap bisa digunakan hingga periode berlangganan berakhir.
                                    </p>
                                </div>
                                
                                <div>
                                    <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                        Apakah ada diskon untuk UKM?
                                    </h3>
                                    <p className="text-gray-600 dark:text-gray-300 text-sm">
                                        Ya! Kami sering memberikan diskon khusus untuk UKM dan startup Indonesia. Follow media sosial kami untuk info promo terbaru.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* CTA Section */}
                    <div className="text-center mt-16 bg-gradient-to-r from-blue-600 to-green-600 rounded-2xl p-12 text-white">
                        <h2 className="text-3xl font-bold mb-4">Masih Ada Pertanyaan? 🤝</h2>
                        <p className="text-xl mb-8 opacity-90">
                            Tim support kami siap membantu Anda memilih paket yang tepat!
                        </p>
                        <div className="flex flex-col sm:flex-row gap-4 justify-center">
                            <a
                                href="mailto:support@kontenlokal.ai"
                                className="bg-white text-blue-600 px-8 py-3 rounded-xl font-semibold hover:bg-gray-100 transition-all"
                            >
                                📧 Email Support
                            </a>
                            <a
                                href="https://wa.me/6281234567890"
                                target="_blank"
                                rel="noopener noreferrer"
                                className="border-2 border-white text-white px-8 py-3 rounded-xl font-semibold hover:bg-white/10 transition-all"
                            >
                                💬 WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}