import React, { useState } from 'react';
import { Head, Link, router } from '@inertiajs/react';
import { Button } from '@/components/ui/button';

interface GeneratedContent {
    id: number;
    title: string;
    generated_content: string | null;
    status: 'pending' | 'processing' | 'completed' | 'failed';
    error_message: string | null;
    credits_used: number;
    processing_time: number | null;
    created_at: string;
    input_data: Record<string, string>;
    content_type: {
        id: number;
        name: string;
        description: string;
    };
}

interface Props {
    content: GeneratedContent;
    [key: string]: unknown;
}

export default function GeneratedContentPage({ content }: Props) {
    const [copied, setCopied] = useState(false);

    const copyToClipboard = async () => {
        if (!content.generated_content) return;
        
        try {
            await navigator.clipboard.writeText(content.generated_content);
            setCopied(true);
            setTimeout(() => setCopied(false), 2000);
        } catch (err) {
            console.error('Failed to copy text: ', err);
        }
    };

    const regenerateContent = () => {
        router.post(route('content.store'), {
            content_type_id: content.content_type.id,
            title: content.title + ' (Regenerated)',
            input_data: content.input_data,
        });
    };

    const getStatusInfo = () => {
        switch (content.status) {
            case 'pending':
                return {
                    icon: '⏳',
                    label: 'Menunggu Diproses',
                    color: 'text-yellow-600 bg-yellow-50 border-yellow-200',
                    description: 'Konten Anda sedang dalam antrian untuk diproses.'
                };
            case 'processing':
                return {
                    icon: '🔄',
                    label: 'Sedang Diproses',
                    color: 'text-blue-600 bg-blue-50 border-blue-200',
                    description: 'AI sedang menghasilkan konten berdasarkan input Anda.'
                };
            case 'completed':
                return {
                    icon: '✅',
                    label: 'Selesai',
                    color: 'text-green-600 bg-green-50 border-green-200',
                    description: 'Konten berhasil dibuat dan siap digunakan!'
                };
            case 'failed':
                return {
                    icon: '❌',
                    label: 'Gagal',
                    color: 'text-red-600 bg-red-50 border-red-200',
                    description: 'Terjadi kesalahan saat membuat konten.'
                };
            default:
                return {
                    icon: '❓',
                    label: 'Unknown',
                    color: 'text-gray-600 bg-gray-50 border-gray-200',
                    description: 'Status tidak diketahui.'
                };
        }
    };

    const statusInfo = getStatusInfo();

    return (
        <>
            <Head title={`${content.title} - KontenLokal AI`} />
            
            <div className="min-h-screen bg-gray-50 dark:bg-gray-900">
                {/* Header */}
                <div className="bg-white dark:bg-gray-800 shadow-sm border-b">
                    <div className="container mx-auto px-4 py-6">
                        <div className="flex items-start justify-between">
                            <div className="flex-1">
                                <div className="flex items-center space-x-2 mb-2">
                                    <Link
                                        href={route('content.index')}
                                        className="text-blue-600 hover:text-blue-700 text-sm font-medium"
                                    >
                                        ← Kembali ke Generator
                                    </Link>
                                </div>
                                <h1 className="text-2xl font-bold text-gray-900 dark:text-white">
                                    {content.title}
                                </h1>
                                <div className="flex items-center space-x-4 mt-2">
                                    <span className="text-sm text-gray-600 dark:text-gray-300">
                                        {content.content_type.name}
                                    </span>
                                    <span className="text-sm text-gray-400">•</span>
                                    <span className="text-sm text-gray-600 dark:text-gray-300">
                                        {new Date(content.created_at).toLocaleString('id-ID')}
                                    </span>
                                    <span className="text-sm text-gray-400">•</span>
                                    <span className="text-sm text-gray-600 dark:text-gray-300">
                                        {content.credits_used} kredit
                                    </span>
                                </div>
                            </div>
                            
                            <div className="flex items-center space-x-3">
                                {content.status === 'completed' && (
                                    <>
                                        <Button
                                            onClick={copyToClipboard}
                                            variant="outline"
                                            className="flex items-center space-x-2"
                                        >
                                            <span>{copied ? '✅' : '📋'}</span>
                                            <span>{copied ? 'Tersalin!' : 'Salin'}</span>
                                        </Button>
                                        <Button
                                            onClick={regenerateContent}
                                            className="bg-blue-600 hover:bg-blue-700 flex items-center space-x-2"
                                        >
                                            <span>🔄</span>
                                            <span>Regenerate</span>
                                        </Button>
                                    </>
                                )}
                            </div>
                        </div>
                    </div>
                </div>

                <div className="container mx-auto px-4 py-8">
                    <div className="grid lg:grid-cols-3 gap-8">
                        {/* Main Content */}
                        <div className="lg:col-span-2">
                            {/* Status Card */}
                            <div className={`rounded-xl border p-6 mb-6 ${statusInfo.color}`}>
                                <div className="flex items-center space-x-3">
                                    <div className="text-2xl">{statusInfo.icon}</div>
                                    <div>
                                        <h3 className="font-semibold text-lg">{statusInfo.label}</h3>
                                        <p className="text-sm opacity-75">{statusInfo.description}</p>
                                        {content.processing_time && (
                                            <p className="text-xs opacity-60 mt-1">
                                                Diproses dalam {content.processing_time} detik
                                            </p>
                                        )}
                                    </div>
                                </div>
                            </div>

                            {/* Generated Content */}
                            {content.status === 'completed' && content.generated_content && (
                                <div className="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                                    <div className="flex items-center justify-between mb-4">
                                        <h2 className="text-xl font-semibold text-gray-900 dark:text-white">
                                            📝 Hasil Konten
                                        </h2>
                                        <Button
                                            onClick={copyToClipboard}
                                            size="sm"
                                            variant="outline"
                                        >
                                            {copied ? '✅ Tersalin' : '📋 Salin'}
                                        </Button>
                                    </div>
                                    
                                    <div className="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                        <pre className="whitespace-pre-wrap text-gray-900 dark:text-white text-sm leading-relaxed font-sans">
                                            {content.generated_content}
                                        </pre>
                                    </div>
                                </div>
                            )}

                            {/* Error Message */}
                            {content.status === 'failed' && content.error_message && (
                                <div className="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-6">
                                    <div className="flex items-start space-x-3">
                                        <div className="text-2xl">❌</div>
                                        <div>
                                            <h3 className="font-semibold text-red-800 dark:text-red-200 mb-2">
                                                Terjadi Kesalahan
                                            </h3>
                                            <p className="text-red-700 dark:text-red-300 text-sm">
                                                {content.error_message}
                                            </p>
                                            <div className="mt-4">
                                                <Button
                                                    onClick={regenerateContent}
                                                    className="bg-red-600 hover:bg-red-700"
                                                >
                                                    🔄 Coba Lagi
                                                </Button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            )}

                            {/* Processing/Pending State */}
                            {(content.status === 'pending' || content.status === 'processing') && (
                                <div className="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-12 text-center">
                                    <div className="animate-spin text-4xl mb-4">🔄</div>
                                    <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                                        {content.status === 'pending' ? 'Menunggu Diproses' : 'Sedang Memproses'}
                                    </h3>
                                    <p className="text-gray-600 dark:text-gray-300 mb-6">
                                        {content.status === 'pending' 
                                            ? 'Konten Anda sedang dalam antrian. Mohon tunggu sebentar...'
                                            : 'AI sedang menghasilkan konten terbaik untuk Anda...'
                                        }
                                    </p>
                                    <Button
                                        onClick={() => window.location.reload()}
                                        variant="outline"
                                    >
                                        🔄 Refresh Halaman
                                    </Button>
                                </div>
                            )}
                        </div>

                        {/* Sidebar */}
                        <div className="lg:col-span-1 space-y-6">
                            {/* Content Type Info */}
                            <div className="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                                    📊 Info Konten
                                </h3>
                                <div className="space-y-3">
                                    <div>
                                        <label className="text-sm font-medium text-gray-500 dark:text-gray-400">Jenis Konten</label>
                                        <p className="text-gray-900 dark:text-white">{content.content_type.name}</p>
                                    </div>
                                    <div>
                                        <label className="text-sm font-medium text-gray-500 dark:text-gray-400">Kredit Digunakan</label>
                                        <p className="text-gray-900 dark:text-white">{content.credits_used}</p>
                                    </div>
                                    <div>
                                        <label className="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Dibuat</label>
                                        <p className="text-gray-900 dark:text-white">
                                            {new Date(content.created_at).toLocaleString('id-ID')}
                                        </p>
                                    </div>
                                    {content.processing_time && (
                                        <div>
                                            <label className="text-sm font-medium text-gray-500 dark:text-gray-400">Waktu Proses</label>
                                            <p className="text-gray-900 dark:text-white">{content.processing_time} detik</p>
                                        </div>
                                    )}
                                </div>
                            </div>

                            {/* Input Data */}
                            <div className="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                                    📝 Data Input
                                </h3>
                                <div className="space-y-3">
                                    {Object.entries(content.input_data).map(([key, value]) => (
                                        <div key={key}>
                                            <label className="text-sm font-medium text-gray-500 dark:text-gray-400 capitalize">
                                                {key.replace('_', ' ')}
                                            </label>
                                            <p className="text-gray-900 dark:text-white text-sm">
                                                {value || '-'}
                                            </p>
                                        </div>
                                    ))}
                                </div>
                            </div>

                            {/* Actions */}
                            <div className="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                                    ⚡ Aksi Cepat
                                </h3>
                                <div className="space-y-3">
                                    <Link
                                        href={route('content.index')}
                                        className="block w-full text-center bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors"
                                    >
                                        ✨ Buat Konten Baru
                                    </Link>
                                    <Link
                                        href={route('content.history')}
                                        className="block w-full text-center border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 py-2 px-4 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                                    >
                                        📋 Lihat Riwayat
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}