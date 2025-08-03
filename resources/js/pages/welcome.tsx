import { type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Welcome() {
    const { auth } = usePage<SharedData>().props;

    return (
        <>
            <Head title="KontenLokal AI - AI Content Generator untuk UKM Indonesia">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>
            <div className="min-h-screen bg-gradient-to-br from-blue-50 via-white to-green-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
                {/* Header */}
                <header className="container mx-auto px-4 py-6">
                    <nav className="flex items-center justify-between">
                        <div className="flex items-center space-x-2">
                            <div className="w-8 h-8 bg-gradient-to-r from-blue-600 to-green-600 rounded-lg flex items-center justify-center">
                                <span className="text-white font-bold text-sm">KL</span>
                            </div>
                            <span className="text-xl font-bold text-gray-900 dark:text-white">KontenLokal AI</span>
                        </div>
                        
                        <div className="flex items-center space-x-4">
                            {auth.user ? (
                                <Link
                                    href={route('dashboard')}
                                    className="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors font-medium"
                                >
                                    Dashboard
                                </Link>
                            ) : (
                                <>
                                    <Link
                                        href={route('login')}
                                        className="text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white transition-colors"
                                    >
                                        Masuk
                                    </Link>
                                    <Link
                                        href={route('register')}
                                        className="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors font-medium"
                                    >
                                        Daftar Gratis
                                    </Link>
                                </>
                            )}
                        </div>
                    </nav>
                </header>

                {/* Hero Section */}
                <main className="container mx-auto px-4 py-16">
                    <div className="text-center max-w-4xl mx-auto">
                        <h1 className="text-5xl md:text-6xl font-bold text-gray-900 dark:text-white mb-6">
                            🤖 <span className="bg-gradient-to-r from-blue-600 to-green-600 bg-clip-text text-transparent">KontenLokal AI</span>
                        </h1>
                        <p className="text-xl md:text-2xl text-gray-600 dark:text-gray-300 mb-8">
                            Platform AI untuk UKM Indonesia menghasilkan konten pemasaran yang <strong>lokal</strong> dan <strong>menarik</strong>
                        </p>
                        <p className="text-lg text-gray-500 dark:text-gray-400 mb-12">
                            Dari script TikTok viral hingga email marketing yang convert - semua dalam bahasa Indonesia yang autentik! 🇮🇩
                        </p>

                        {!auth.user && (
                            <div className="flex flex-col sm:flex-row gap-4 justify-center mb-16">
                                <Link
                                    href={route('register')}
                                    className="bg-gradient-to-r from-blue-600 to-green-600 text-white px-8 py-4 rounded-xl text-lg font-semibold hover:from-blue-700 hover:to-green-700 transform hover:scale-105 transition-all shadow-lg"
                                >
                                    🚀 Mulai Gratis - 20 Kredit
                                </Link>
                                <Link
                                    href={route('pricing')}
                                    className="border-2 border-blue-600 text-blue-600 px-8 py-4 rounded-xl text-lg font-semibold hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all"
                                >
                                    💰 Lihat Harga
                                </Link>
                            </div>
                        )}
                    </div>

                    {/* Features Grid */}
                    <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">
                        <div className="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                            <div className="text-3xl mb-4">🎬</div>
                            <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-2">Script TikTok/Reels</h3>
                            <p className="text-gray-600 dark:text-gray-300">Buat script video viral yang engaging dalam hitungan detik</p>
                        </div>
                        
                        <div className="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                            <div className="text-3xl mb-4">📧</div>
                            <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-2">Email Marketing</h3>
                            <p className="text-gray-600 dark:text-gray-300">Campaign email yang convert dan membangun loyalitas customer</p>
                        </div>
                        
                        <div className="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                            <div className="text-3xl mb-4">💬</div>
                            <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-2">Balasan Review</h3>
                            <p className="text-gray-600 dark:text-gray-300">Respon profesional untuk review pelanggan di marketplace</p>
                        </div>
                        
                        <div className="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                            <div className="text-3xl mb-4">📱</div>
                            <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-2">Caption Instagram</h3>
                            <p className="text-gray-600 dark:text-gray-300">Caption menarik dengan hashtag yang tepat untuk Instagram</p>
                        </div>
                    </div>

                    {/* Special Features */}
                    <div className="bg-gradient-to-r from-blue-100 to-green-100 dark:from-blue-900/20 dark:to-green-900/20 rounded-2xl p-8 mb-16">
                        <h2 className="text-3xl font-bold text-center text-gray-900 dark:text-white mb-8">
                            🇮🇩 Dibuat Khusus untuk Indonesia
                        </h2>
                        <div className="grid md:grid-cols-3 gap-6">
                            <div className="text-center">
                                <div className="text-4xl mb-4">🗓️</div>
                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-2">Kalender Ide Konten</h3>
                                <p className="text-gray-600 dark:text-gray-300">Ide konten untuk hari besar dan momen penting Indonesia</p>
                            </div>
                            <div className="text-center">
                                <div className="text-4xl mb-4">🎯</div>
                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-2">Brand Voice Personal</h3>
                                <p className="text-gray-600 dark:text-gray-300">AI yang memahami karakteristik dan gaya komunikasi brand Anda</p>
                            </div>
                            <div className="text-center">
                                <div className="text-4xl mb-4">⚡</div>
                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-2">Proses Super Cepat</h3>
                                <p className="text-gray-600 dark:text-gray-300">Konten berkualitas dalam waktu kurang dari 30 detik</p>
                            </div>
                        </div>
                    </div>

                    {/* Testimonial Preview */}
                    <div className="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg mb-16">
                        <div className="text-center mb-8">
                            <h2 className="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                                💝 Dipercaya UKM di Seluruh Indonesia
                            </h2>
                            <p className="text-gray-600 dark:text-gray-300">Dari warung kopi hingga toko fashion online - semua menggunakan KontenLokal AI</p>
                        </div>
                        
                        <div className="grid md:grid-cols-3 gap-6">
                            <div className="text-center p-4">
                                <div className="text-yellow-400 text-2xl mb-2">⭐⭐⭐⭐⭐</div>
                                <p className="text-gray-600 dark:text-gray-300 italic mb-4">"Script TikTok yang dihasilkan bener-bener viral! Followers naik 300% dalam sebulan"</p>
                                <p className="font-semibold text-gray-900 dark:text-white">- Sari, Owner Kopi Nusantara</p>
                            </div>
                            <div className="text-center p-4">
                                <div className="text-yellow-400 text-2xl mb-2">⭐⭐⭐⭐⭐</div>
                                <p className="text-gray-600 dark:text-gray-300 italic mb-4">"Email marketing-nya benar-benar convert. Sales online shop naik 150%!"</p>
                                <p className="font-semibold text-gray-900 dark:text-white">- Budi, Fashion Store Owner</p>
                            </div>
                            <div className="text-center p-4">
                                <div className="text-yellow-400 text-2xl mb-2">⭐⭐⭐⭐⭐</div>
                                <p className="text-gray-600 dark:text-gray-300 italic mb-4">"Balasan review pelanggan jadi lebih profesional. Rating toko naik jadi 4.9!"</p>
                                <p className="font-semibold text-gray-900 dark:text-white">- Dewi, Marketplace Seller</p>
                            </div>
                        </div>
                    </div>

                    {/* CTA Section */}
                    {!auth.user && (
                        <div className="text-center bg-gradient-to-r from-blue-600 to-green-600 rounded-2xl p-12 text-white">
                            <h2 className="text-3xl font-bold mb-4">Siap Tingkatkan Konten Marketing Anda? 🚀</h2>
                            <p className="text-xl mb-8 opacity-90">Mulai gratis hari ini - dapatkan 20 kredit untuk mencoba semua fitur!</p>
                            <div className="flex flex-col sm:flex-row gap-4 justify-center">
                                <Link
                                    href={route('register')}
                                    className="bg-white text-blue-600 px-8 py-4 rounded-xl text-lg font-semibold hover:bg-gray-100 transform hover:scale-105 transition-all shadow-lg"
                                >
                                    ✨ Daftar Gratis Sekarang
                                </Link>
                                <Link
                                    href={route('pricing')}
                                    className="border-2 border-white text-white px-8 py-4 rounded-xl text-lg font-semibold hover:bg-white/10 transition-all"
                                >
                                    📊 Lihat Semua Paket
                                </Link>
                            </div>
                        </div>
                    )}
                </main>

                {/* Footer */}
                <footer className="border-t border-gray-200 dark:border-gray-700 py-12">
                    <div className="container mx-auto px-4 text-center">
                        <div className="flex items-center justify-center space-x-2 mb-4">
                            <div className="w-6 h-6 bg-gradient-to-r from-blue-600 to-green-600 rounded flex items-center justify-center">
                                <span className="text-white font-bold text-xs">KL</span>
                            </div>
                            <span className="text-lg font-bold text-gray-900 dark:text-white">KontenLokal AI</span>
                        </div>
                        <p className="text-gray-600 dark:text-gray-300 mb-4">
                            Platform AI Content Generator #1 untuk UKM Indonesia 🇮🇩
                        </p>
                        <p className="text-sm text-gray-500 dark:text-gray-400">
                            © 2024 KontenLokal AI. Dibuat dengan ❤️ untuk UKM Indonesia.
                        </p>
                    </div>
                </footer>
            </div>
        </>
    );
}