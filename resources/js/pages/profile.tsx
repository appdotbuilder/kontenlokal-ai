import React, { useState } from 'react';
import { Head, useForm, Link } from '@inertiajs/react';
import { Button } from '@/components/ui/button';

interface User {
    id: number;
    name: string;
    email: string;
    credits: number;
    brand_voice: string | null;
    subscription_tier: string;
    created_at: string;
}

interface Subscription {
    tier: string;
    expires_at: string | null;
    is_active: boolean;
}

interface Props {
    user: User;
    subscription: Subscription;
    [key: string]: unknown;
}

export default function Profile({ user, subscription }: Props) {
    const [isEditing, setIsEditing] = useState(false);
    
    const { data, setData, put, processing, errors, reset } = useForm({
        brand_voice: user.brand_voice || '',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        put(route('profile.brand-voice.update'), {
            onSuccess: () => {
                setIsEditing(false);
            },
        });
    };

    const getTierLabel = (tier: string) => {
        const labels = {
            free: 'Gratis',
            basic: 'Basic',
            pro: 'Pro',
            enterprise: 'Enterprise',
        };
        return labels[tier as keyof typeof labels] || tier;
    };

    const getTierColor = (tier: string) => {
        const colors = {
            free: 'bg-gray-100 text-gray-800 border-gray-200',
            basic: 'bg-blue-100 text-blue-800 border-blue-200',
            pro: 'bg-purple-100 text-purple-800 border-purple-200',
            enterprise: 'bg-green-100 text-green-800 border-green-200',
        };
        return colors[tier as keyof typeof colors] || 'bg-gray-100 text-gray-800 border-gray-200';
    };

    return (
        <>
            <Head title="Profil - KontenLokal AI" />
            
            <div className="min-h-screen bg-gray-50 dark:bg-gray-900">
                {/* Header */}
                <div className="bg-white dark:bg-gray-800 shadow-sm border-b">
                    <div className="container mx-auto px-4 py-6">
                        <div className="flex items-center justify-between">
                            <div>
                                <h1 className="text-2xl font-bold text-gray-900 dark:text-white">
                                    👤 Profil Saya
                                </h1>
                                <p className="text-gray-600 dark:text-gray-300 mt-1">
                                    Kelola informasi akun dan preferensi Anda
                                </p>
                            </div>
                            <Link
                                href={route('content.index')}
                                className="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors"
                            >
                                ← Kembali ke Generator
                            </Link>
                        </div>
                    </div>
                </div>

                <div className="container mx-auto px-4 py-8">
                    <div className="grid lg:grid-cols-3 gap-8">
                        {/* Profile Info */}
                        <div className="lg:col-span-1">
                            <div className="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                                <div className="text-center mb-6">
                                    <div className="w-20 h-20 bg-gradient-to-r from-blue-600 to-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <span className="text-white text-2xl font-bold">
                                            {user.name.charAt(0).toUpperCase()}
                                        </span>
                                    </div>
                                    <h2 className="text-xl font-semibold text-gray-900 dark:text-white">
                                        {user.name}
                                    </h2>
                                    <p className="text-gray-600 dark:text-gray-300 text-sm">
                                        {user.email}
                                    </p>
                                </div>

                                <div className="space-y-4">
                                    <div className="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <span className="text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Kredit Tersisa
                                        </span>
                                        <span className="text-lg font-bold text-blue-600">
                                            {user.credits}
                                        </span>
                                    </div>
                                    
                                    <div className="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <span className="text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Paket Berlangganan
                                        </span>
                                        <span className={`px-2 py-1 text-xs font-medium rounded border ${getTierColor(subscription.tier)}`}>
                                            {getTierLabel(subscription.tier)}
                                        </span>
                                    </div>
                                    
                                    <div className="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <span className="text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Member Sejak
                                        </span>
                                        <span className="text-sm text-gray-600 dark:text-gray-300">
                                            {new Date(user.created_at).toLocaleDateString('id-ID', {
                                                month: 'long',
                                                year: 'numeric'
                                            })}
                                        </span>
                                    </div>
                                </div>

                                <div className="mt-6 pt-6 border-t border-gray-200 dark:border-gray-600">
                                    <Link
                                        href={route('pricing')}
                                        className="block w-full text-center bg-gradient-to-r from-blue-600 to-green-600 text-white py-2 px-4 rounded-lg hover:from-blue-700 hover:to-green-700 transition-all font-medium"
                                    >
                                        💰 Upgrade Paket
                                    </Link>
                                </div>
                            </div>
                        </div>

                        {/* Brand Voice Settings */}
                        <div className="lg:col-span-2">
                            <div className="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                                <div className="flex items-center justify-between mb-6">
                                    <div>
                                        <h3 className="text-xl font-semibold text-gray-900 dark:text-white">
                                            🎯 Brand Voice Personal
                                        </h3>
                                        <p className="text-gray-600 dark:text-gray-300 text-sm mt-1">
                                            Deskripsi ini akan membantu AI memahami gaya komunikasi brand Anda
                                        </p>
                                    </div>
                                    {!isEditing && (
                                        <Button
                                            onClick={() => setIsEditing(true)}
                                            variant="outline"
                                        >
                                            ✏️ Edit
                                        </Button>
                                    )}
                                </div>

                                {isEditing ? (
                                    <form onSubmit={handleSubmit} className="space-y-4">
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Deskripsi Brand Voice
                                            </label>
                                            <textarea
                                                value={data.brand_voice}
                                                onChange={(e) => setData('brand_voice', e.target.value)}
                                                rows={6}
                                                className="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                                                placeholder="Contoh: Ramah, profesional, dan menggunakan bahasa yang mudah dipahami. Fokus pada nilai kualitas dan kepercayaan pelanggan. Hindari penggunaan kata-kata yang terlalu formal atau kaku..."
                                            />
                                            {errors.brand_voice && (
                                                <p className="text-red-500 text-sm mt-1">{errors.brand_voice}</p>
                                            )}
                                        </div>
                                        
                                        <div className="flex items-center space-x-3">
                                            <Button
                                                type="submit"
                                                disabled={processing}
                                                className="bg-blue-600 hover:bg-blue-700"
                                            >
                                                {processing ? '💾 Menyimpan...' : '💾 Simpan'}
                                            </Button>
                                            <Button
                                                type="button"
                                                variant="outline"
                                                onClick={() => {
                                                    setIsEditing(false);
                                                    reset();
                                                }}
                                            >
                                                Batal
                                            </Button>
                                        </div>
                                    </form>
                                ) : (
                                    <div className="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                        {user.brand_voice ? (
                                            <p className="text-gray-700 dark:text-gray-300 leading-relaxed">
                                                {user.brand_voice}
                                            </p>
                                        ) : (
                                            <div className="text-center py-8">
                                                <div className="text-4xl mb-3">🎯</div>
                                                <h4 className="font-medium text-gray-900 dark:text-white mb-2">
                                                    Belum Ada Brand Voice
                                                </h4>
                                                <p className="text-gray-600 dark:text-gray-300 text-sm mb-4">
                                                    Tambahkan deskripsi brand voice untuk hasil konten yang lebih personal dan sesuai dengan karakter brand Anda.
                                                </p>
                                                <Button
                                                    onClick={() => setIsEditing(true)}
                                                    className="bg-blue-600 hover:bg-blue-700"
                                                >
                                                    ✏️ Tambah Brand Voice
                                                </Button>
                                            </div>
                                        )}
                                    </div>
                                )}
                            </div>

                            {/* Tips Section */}
                            <div className="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-6 mt-6">
                                <h4 className="font-semibold text-blue-900 dark:text-blue-100 mb-3">
                                    💡 Tips Membuat Brand Voice yang Efektif
                                </h4>
                                <ul className="space-y-2 text-blue-800 dark:text-blue-200 text-sm">
                                    <li className="flex items-start space-x-2">
                                        <span className="text-blue-500 mt-1">•</span>
                                        <span>Jelaskan tone of voice: formal, santai, friendly, profesional, dll.</span>
                                    </li>
                                    <li className="flex items-start space-x-2">
                                        <span className="text-blue-500 mt-1">•</span>
                                        <span>Sebutkan target audience: usia, profesi, karakteristik</span>
                                    </li>
                                    <li className="flex items-start space-x-2">
                                        <span className="text-blue-500 mt-1">•</span>
                                        <span>Cantumkan nilai-nilai brand: kepercayaan, kualitas, inovasi, dll.</span>
                                    </li>
                                    <li className="flex items-start space-x-2">
                                        <span className="text-blue-500 mt-1">•</span>
                                        <span>Hindari atau gunakan istilah khusus yang relevan dengan industri</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}