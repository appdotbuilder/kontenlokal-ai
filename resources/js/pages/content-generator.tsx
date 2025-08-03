import React, { useState } from 'react';
import { Head, useForm, Link } from '@inertiajs/react';
import { Button } from '@/components/ui/button';

interface ContentType {
    id: number;
    name: string;
    slug: string;
    description: string;
    credit_cost: number;
    input_fields: Array<{
        name: string;
        label: string;
        type: 'text' | 'textarea' | 'select';
        placeholder?: string;
        required: boolean;
        options?: Array<{ value: string; label: string }>;
    }>;
}

interface GeneratedContent {
    id: number;
    title: string;
    status: 'pending' | 'processing' | 'completed' | 'failed';
    created_at: string;
    content_type: {
        name: string;
    };
}

interface Props {
    contentTypes: ContentType[];
    recentContents: GeneratedContent[];
    userCredits: number;
    [key: string]: unknown;
}

export default function ContentGenerator({ contentTypes, recentContents, userCredits }: Props) {
    const [selectedType, setSelectedType] = useState<ContentType | null>(null);
    const { data, setData, post, processing, errors, reset } = useForm({
        content_type_id: '',
        title: '',
        input_data: {} as Record<string, string>,
    });

    const handleTypeSelect = (type: ContentType) => {
        setSelectedType(type);
        setData('content_type_id', type.id.toString());
        
        // Initialize input data with empty values
        const initialInputData: Record<string, string> = {};
        type.input_fields.forEach(field => {
            initialInputData[field.name] = '';
        });
        setData('input_data', initialInputData);
    };

    const handleInputChange = (fieldName: string, value: string) => {
        setData('input_data', {
            ...data.input_data,
            [fieldName]: value,
        });
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        
        if (!selectedType) return;
        
        if (userCredits < selectedType.credit_cost) {
            alert('Kredit tidak mencukupi. Silakan upgrade paket Anda.');
            return;
        }

        post(route('content.store'), {
            onSuccess: () => {
                reset();
                setSelectedType(null);
            },
        });
    };

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

    return (
        <>
            <Head title="Generator Konten - KontenLokal AI" />
            
            <div className="min-h-screen bg-gray-50 dark:bg-gray-900">
                {/* Header */}
                <div className="bg-white dark:bg-gray-800 shadow-sm border-b">
                    <div className="container mx-auto px-4 py-6">
                        <div className="flex items-center justify-between">
                            <div>
                                <h1 className="text-2xl font-bold text-gray-900 dark:text-white">
                                    🤖 Generator Konten AI
                                </h1>
                                <p className="text-gray-600 dark:text-gray-300 mt-1">
                                    Buat konten pemasaran yang menarik dalam hitungan detik
                                </p>
                            </div>
                            <div className="flex items-center space-x-4">
                                <div className="text-right">
                                    <p className="text-sm text-gray-500 dark:text-gray-400">Kredit Tersisa</p>
                                    <p className="text-2xl font-bold text-blue-600">{userCredits}</p>
                                </div>
                                <Link
                                    href={route('pricing')}
                                    className="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors"
                                >
                                    Upgrade
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="container mx-auto px-4 py-8">
                    <div className="grid lg:grid-cols-3 gap-8">
                        {/* Content Type Selection */}
                        <div className="lg:col-span-2">
                            {!selectedType ? (
                                <div>
                                    <h2 className="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                                        Pilih Jenis Konten
                                    </h2>
                                    <div className="grid md:grid-cols-2 gap-4">
                                        {contentTypes.map((type) => (
                                            <div
                                                key={type.id}
                                                onClick={() => handleTypeSelect(type)}
                                                className="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md hover:border-blue-300 cursor-pointer transition-all group"
                                            >
                                                <div className="flex items-start justify-between mb-3">
                                                    <h3 className="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 transition-colors">
                                                        {type.name}
                                                    </h3>
                                                    <span className="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded">
                                                        {type.credit_cost} kredit
                                                    </span>
                                                </div>
                                                <p className="text-gray-600 dark:text-gray-300 text-sm">
                                                    {type.description}
                                                </p>
                                            </div>
                                        ))}
                                    </div>
                                </div>
                            ) : (
                                <div className="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                                    <div className="flex items-center justify-between mb-6">
                                        <div>
                                            <h2 className="text-xl font-semibold text-gray-900 dark:text-white">
                                                {selectedType.name}
                                            </h2>
                                            <p className="text-gray-600 dark:text-gray-300 text-sm mt-1">
                                                {selectedType.description}
                                            </p>
                                        </div>
                                        <Button
                                            type="button"
                                            variant="outline"
                                            onClick={() => {
                                                setSelectedType(null);
                                                reset();
                                            }}
                                        >
                                            Ganti Jenis
                                        </Button>
                                    </div>

                                    <form onSubmit={handleSubmit} className="space-y-6">
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Judul Konten *
                                            </label>
                                            <input
                                                type="text"
                                                value={data.title}
                                                onChange={(e) => setData('title', e.target.value)}
                                                placeholder="Berikan judul untuk konten ini..."
                                                className="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                                                required
                                            />
                                            {errors.title && <p className="text-red-500 text-sm mt-1">{errors.title}</p>}
                                        </div>

                                        {selectedType.input_fields.map((field) => (
                                            <div key={field.name}>
                                                <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                    {field.label} {field.required && '*'}
                                                </label>
                                                
                                                {field.type === 'textarea' ? (
                                                    <textarea
                                                        value={data.input_data[field.name] || ''}
                                                        onChange={(e) => handleInputChange(field.name, e.target.value)}
                                                        placeholder={field.placeholder}
                                                        rows={4}
                                                        className="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                                                        required={field.required}
                                                    />
                                                ) : field.type === 'select' ? (
                                                    <select
                                                        value={data.input_data[field.name] || ''}
                                                        onChange={(e) => handleInputChange(field.name, e.target.value)}
                                                        className="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                                                        required={field.required}
                                                    >
                                                        <option value="">Pilih...</option>
                                                        {field.options?.map((option) => (
                                                            <option key={option.value} value={option.value}>
                                                                {option.label}
                                                            </option>
                                                        ))}
                                                    </select>
                                                ) : (
                                                    <input
                                                        type="text"
                                                        value={data.input_data[field.name] || ''}
                                                        onChange={(e) => handleInputChange(field.name, e.target.value)}
                                                        placeholder={field.placeholder}
                                                        className="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                                                        required={field.required}
                                                    />
                                                )}
                                            </div>
                                        ))}

                                        <div className="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-600">
                                            <div className="text-sm text-gray-600 dark:text-gray-300">
                                                Biaya: <span className="font-semibold">{selectedType.credit_cost} kredit</span>
                                            </div>
                                            <Button
                                                type="submit"
                                                disabled={processing || userCredits < selectedType.credit_cost}
                                                className="bg-blue-600 hover:bg-blue-700"
                                            >
                                                {processing ? '🔄 Memproses...' : '✨ Generate Konten'}
                                            </Button>
                                        </div>
                                    </form>
                                </div>
                            )}
                        </div>

                        {/* Recent Contents Sidebar */}
                        <div className="lg:col-span-1">
                            <div className="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                    📋 Konten Terbaru
                                </h3>
                                
                                {recentContents.length > 0 ? (
                                    <div className="space-y-3">
                                        {recentContents.map((content) => (
                                            <Link
                                                key={content.id}
                                                href={route('content.show', content.id)}
                                                className="block p-3 rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                                            >
                                                <div className="flex items-center justify-between mb-2">
                                                    <h4 className="font-medium text-gray-900 dark:text-white text-sm truncate">
                                                        {content.title}
                                                    </h4>
                                                    {getStatusBadge(content.status)}
                                                </div>
                                                <div className="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                                                    <span>{content.content_type.name}</span>
                                                    <span>{new Date(content.created_at).toLocaleDateString('id-ID')}</span>
                                                </div>
                                            </Link>
                                        ))}
                                    </div>
                                ) : (
                                    <div className="text-center py-8">
                                        <div className="text-4xl mb-3">📝</div>
                                        <p className="text-gray-500 dark:text-gray-400 text-sm">
                                            Belum ada konten yang dibuat
                                        </p>
                                    </div>
                                )}

                                <div className="mt-6 pt-4 border-t border-gray-200 dark:border-gray-600">
                                    <Link
                                        href={route('content.history')}
                                        className="block text-center text-blue-600 hover:text-blue-700 text-sm font-medium"
                                    >
                                        Lihat Semua Riwayat →
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