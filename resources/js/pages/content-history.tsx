import React from 'react';
import { Head, Link, router } from '@inertiajs/react';
import { Button } from '@/components/ui/button';

interface GeneratedContent {
    id: number;
    title: string;
    status: 'pending' | 'processing' | 'completed' | 'failed';
    credits_used: number;
    created_at: string;
    content_type: {
        name: string;
    };
}

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface PaginationMeta {
    from: number;
    to: number;
    total: number;
    last_page: number;
}

interface Props {
    contents: {
        data: GeneratedContent[];
        links: PaginationLink[];
        meta: PaginationMeta;
    };
    filters: {
        status?: string;
        content_type?: string;
        search?: string;
    };
    [key: string]: unknown;
}

export default function ContentHistory({ contents, filters }: Props) {
    const getStatusBadge = (status: string) => {
        const badges = {
            pending: 'bg-yellow-100 text-yellow-800 border-yellow-200',
            processing: 'bg-blue-100 text-blue-800 border-blue-200',
            completed: 'bg-green-100 text-green-800 border-green-200',
            failed: 'bg-red-100 text-red-800 border-red-200',
        };
        
        const labels = {
            pending: 'Menunggu',
            processing: 'Diproses',
            completed: 'Selesai',
            failed: 'Gagal',
        };

        return (
            <span className={`px-2 py-1 text-xs font-medium rounded border ${badges[status as keyof typeof badges]}`}>
                {labels[status as keyof typeof labels]}
            </span>
        );
    };

    const handleDelete = (contentId: number) => {
        if (confirm('Apakah Anda yakin ingin menghapus konten ini?')) {
            router.delete(route('content.destroy', contentId));
        }
    };

    return (
        <>
            <Head title="Riwayat Konten - KontenLokal AI" />
            
            <div className="min-h-screen bg-gray-50 dark:bg-gray-900">
                {/* Header */}
                <div className="bg-white dark:bg-gray-800 shadow-sm border-b">
                    <div className="container mx-auto px-4 py-6">
                        <div className="flex items-center justify-between">
                            <div>
                                <h1 className="text-2xl font-bold text-gray-900 dark:text-white">
                                    📋 Riwayat Konten
                                </h1>
                                <p className="text-gray-600 dark:text-gray-300 mt-1">
                                    Kelola semua konten yang pernah Anda buat
                                </p>
                            </div>
                            <Link
                                href={route('content.index')}
                                className="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors"
                            >
                                ✨ Buat Konten Baru
                            </Link>
                        </div>
                    </div>
                </div>

                <div className="container mx-auto px-4 py-8">
                    {/* Search and Filters */}
                    <div className="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                        <div className="flex flex-col md:flex-row gap-4">
                            <div className="flex-1">
                                <input
                                    type="text"
                                    placeholder="Cari berdasarkan judul..."
                                    defaultValue={filters.search || ''}
                                    className="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                                    onChange={(e) => {
                                        const url = new URL(window.location.href);
                                        if (e.target.value) {
                                            url.searchParams.set('search', e.target.value);
                                        } else {
                                            url.searchParams.delete('search');
                                        }
                                        router.get(url.toString(), {}, { preserveState: true, replace: true });
                                    }}
                                />
                            </div>
                            <div className="flex gap-3">
                                <select
                                    defaultValue={filters.status || ''}
                                    onChange={(e) => {
                                        const url = new URL(window.location.href);
                                        if (e.target.value) {
                                            url.searchParams.set('status', e.target.value);
                                        } else {
                                            url.searchParams.delete('status');
                                        }
                                        router.get(url.toString(), {}, { preserveState: true, replace: true });
                                    }}
                                    className="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                                >
                                    <option value="">Semua Status</option>
                                    <option value="completed">Selesai</option>
                                    <option value="processing">Diproses</option>
                                    <option value="pending">Menunggu</option>
                                    <option value="failed">Gagal</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {/* Content List */}
                    {contents.data.length > 0 ? (
                        <div className="space-y-4">
                            {contents.data.map((content) => (
                                <div
                                    key={content.id}
                                    className="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition-shadow"
                                >
                                    <div className="flex items-start justify-between">
                                        <div className="flex-1">
                                            <div className="flex items-center space-x-3 mb-2">
                                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white">
                                                    {content.title}
                                                </h3>
                                                {getStatusBadge(content.status)}
                                            </div>
                                            
                                            <div className="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                                                <span>{content.content_type.name}</span>
                                                <span>•</span>
                                                <span>{content.credits_used} kredit</span>
                                                <span>•</span>
                                                <span>{new Date(content.created_at).toLocaleString('id-ID')}</span>
                                            </div>
                                        </div>
                                        
                                        <div className="flex items-center space-x-2">
                                            <Link
                                                href={route('content.show', content.id)}
                                                className="text-blue-600 hover:text-blue-700 px-3 py-1 text-sm font-medium"
                                            >
                                                Lihat
                                            </Link>
                                            <Button
                                                onClick={() => handleDelete(content.id)}
                                                variant="outline"
                                                size="sm"
                                                className="text-red-600 hover:text-red-700 hover:border-red-300"
                                            >
                                                Hapus
                                            </Button>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    ) : (
                        <div className="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-12 text-center">
                            <div className="text-6xl mb-4">📝</div>
                            <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                                Belum Ada Konten
                            </h3>
                            <p className="text-gray-600 dark:text-gray-300 mb-6">
                                Anda belum membuat konten apapun. Mari mulai dengan membuat konten pertama!
                            </p>
                            <Link
                                href={route('content.index')}
                                className="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-medium"
                            >
                                ✨ Buat Konten Pertama
                            </Link>
                        </div>
                    )}

                    {/* Pagination */}
                    {contents.meta.last_page > 1 && (
                        <div className="flex items-center justify-between mt-8">
                            <div className="text-sm text-gray-500 dark:text-gray-400">
                                Menampilkan {contents.meta.from} - {contents.meta.to} dari {contents.meta.total} konten
                            </div>
                            
                            <div className="flex items-center space-x-2">
                                {contents.links.map((link, index) => (
                                    <Link
                                        key={index}
                                        href={link.url || '#'}
                                        className={`px-3 py-2 text-sm rounded-lg transition-colors ${
                                            link.active
                                                ? 'bg-blue-600 text-white'
                                                : link.url
                                                ? 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
                                                : 'text-gray-400 cursor-not-allowed'
                                        }`}
                                        preserveState
                                        preserveScroll
                                    >
                                        <span dangerouslySetInnerHTML={{ __html: link.label }} />
                                    </Link>
                                ))}
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </>
    );
}