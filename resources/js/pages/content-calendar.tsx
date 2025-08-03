import React, { useState } from 'react';
import { Head, Link } from '@inertiajs/react';
import { Button } from '@/components/ui/button';

interface ContentCalendarEvent {
    id: number;
    event_date: string;
    event_name: string;
    event_type: string;
    description: string;
    content_ideas: string[];
    hashtags: string[] | null;
    hashtags_string: string;
}

interface Props {
    events: ContentCalendarEvent[];
    upcomingEvents: ContentCalendarEvent[];
    currentMonth: number;
    currentYear: number;
    [key: string]: unknown;
}

export default function ContentCalendar({ events, upcomingEvents, currentMonth, currentYear }: Props) {
    const [selectedEvent, setSelectedEvent] = useState<ContentCalendarEvent | null>(null);

    const monthNames = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    const getEventTypeColor = (type: string) => {
        const colors = {
            national_holiday: 'bg-red-100 text-red-800 border-red-200',
            religious: 'bg-green-100 text-green-800 border-green-200',
            cultural: 'bg-purple-100 text-purple-800 border-purple-200',
            commercial: 'bg-blue-100 text-blue-800 border-blue-200',
            international: 'bg-yellow-100 text-yellow-800 border-yellow-200',
        };
        return colors[type as keyof typeof colors] || 'bg-gray-100 text-gray-800 border-gray-200';
    };

    const getEventTypeLabel = (type: string) => {
        const labels = {
            national_holiday: 'Hari Libur Nasional',
            religious: 'Hari Keagamaan',
            cultural: 'Budaya',
            commercial: 'Komersial',
            international: 'Internasional',
        };
        return labels[type as keyof typeof labels] || type;
    };

    const getEventIcon = (type: string) => {
        const icons = {
            national_holiday: '🇮🇩',
            religious: '🕌',
            cultural: '🎭',
            commercial: '🛒',
            international: '🌍',
        };
        return icons[type as keyof typeof icons] || '📅';
    };

    const formatDate = (dateString: string) => {
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });
    };

    return (
        <>
            <Head title="Kalender Ide Konten - KontenLokal AI" />
            
            <div className="min-h-screen bg-gray-50 dark:bg-gray-900">
                {/* Header */}
                <div className="bg-white dark:bg-gray-800 shadow-sm border-b">
                    <div className="container mx-auto px-4 py-6">
                        <div className="flex items-center justify-between">
                            <div>
                                <h1 className="text-2xl font-bold text-gray-900 dark:text-white">
                                    🗓️ Kalender Ide Konten
                                </h1>
                                <p className="text-gray-600 dark:text-gray-300 mt-1">
                                    Ide konten untuk hari besar dan momen penting Indonesia
                                </p>
                            </div>
                            <div className="text-right">
                                <p className="text-lg font-semibold text-gray-900 dark:text-white">
                                    {monthNames[currentMonth - 1]} {currentYear}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="container mx-auto px-4 py-8">
                    <div className="grid lg:grid-cols-4 gap-8">
                        {/* Upcoming Events Sidebar */}
                        <div className="lg:col-span-1">
                            <div className="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 sticky top-8">
                                <h2 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                    ⭐ Event Mendatang
                                </h2>
                                
                                {upcomingEvents.length > 0 ? (
                                    <div className="space-y-3">
                                        {upcomingEvents.map((event) => (
                                            <div
                                                key={event.id}
                                                onClick={() => setSelectedEvent(event)}
                                                className="p-3 rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors"
                                            >
                                                <div className="flex items-start space-x-2">
                                                    <span className="text-lg">{getEventIcon(event.event_type)}</span>
                                                    <div className="flex-1 min-w-0">
                                                        <h3 className="font-medium text-gray-900 dark:text-white text-sm truncate">
                                                            {event.event_name}
                                                        </h3>
                                                        <p className="text-xs text-gray-500 dark:text-gray-400">
                                                            {formatDate(event.event_date)}
                                                        </p>
                                                        <span className={`inline-block px-2 py-1 text-xs rounded mt-1 ${getEventTypeColor(event.event_type)}`}>
                                                            {getEventTypeLabel(event.event_type)}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        ))}
                                    </div>
                                ) : (
                                    <div className="text-center py-8">
                                        <div className="text-4xl mb-3">📅</div>
                                        <p className="text-gray-500 dark:text-gray-400 text-sm">
                                            Tidak ada event mendatang
                                        </p>
                                    </div>
                                )}
                            </div>
                        </div>

                        {/* Events List */}
                        <div className="lg:col-span-3">
                            <div className="space-y-6">
                                {events.length > 0 ? (
                                    events.map((event) => (
                                        <div
                                            key={event.id}
                                            className="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition-shadow"
                                        >
                                            <div className="flex items-start justify-between mb-4">
                                                <div className="flex items-start space-x-3">
                                                    <div className="text-3xl">{getEventIcon(event.event_type)}</div>
                                                    <div>
                                                        <h3 className="text-xl font-semibold text-gray-900 dark:text-white">
                                                            {event.event_name}
                                                        </h3>
                                                        <p className="text-gray-600 dark:text-gray-300 mt-1">
                                                            {formatDate(event.event_date)}
                                                        </p>
                                                        <span className={`inline-block px-3 py-1 text-sm rounded-full mt-2 ${getEventTypeColor(event.event_type)}`}>
                                                            {getEventTypeLabel(event.event_type)}
                                                        </span>
                                                    </div>
                                                </div>
                                                <Button
                                                    onClick={() => setSelectedEvent(event)}
                                                    variant="outline"
                                                    size="sm"
                                                >
                                                    Lihat Detail
                                                </Button>
                                            </div>

                                            <p className="text-gray-600 dark:text-gray-300 mb-4">
                                                {event.description}
                                            </p>

                                            {/* Content Ideas Preview */}
                                            <div className="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                                <h4 className="font-medium text-gray-900 dark:text-white mb-3">
                                                    💡 Ide Konten:
                                                </h4>
                                                <ul className="space-y-2">
                                                    {event.content_ideas.slice(0, 3).map((idea, index) => (
                                                        <li key={index} className="flex items-start space-x-2">
                                                            <span className="text-blue-500 mt-1">•</span>
                                                            <span className="text-gray-700 dark:text-gray-300 text-sm">
                                                                {idea}
                                                            </span>
                                                        </li>
                                                    ))}
                                                    {event.content_ideas.length > 3 && (
                                                        <li className="text-blue-600 text-sm font-medium">
                                                            +{event.content_ideas.length - 3} ide lainnya...
                                                        </li>
                                                    )}
                                                </ul>
                                            </div>

                                            {/* Hashtags */}
                                            {event.hashtags && event.hashtags.length > 0 && (
                                                <div className="mt-4">
                                                    <h4 className="font-medium text-gray-900 dark:text-white mb-2 text-sm">
                                                        🏷️ Hashtag:
                                                    </h4>
                                                    <div className="flex flex-wrap gap-2">
                                                        {event.hashtags.slice(0, 5).map((tag, index) => (
                                                            <span
                                                                key={index}
                                                                className="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded"
                                                            >
                                                                #{tag}
                                                            </span>
                                                        ))}
                                                        {event.hashtags.length > 5 && (
                                                            <span className="text-blue-600 text-xs">
                                                                +{event.hashtags.length - 5} lainnya
                                                            </span>
                                                        )}
                                                    </div>
                                                </div>
                                            )}
                                        </div>
                                    ))
                                ) : (
                                    <div className="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-12 text-center">
                                        <div className="text-6xl mb-4">📅</div>
                                        <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                                            Tidak Ada Event Bulan Ini
                                        </h3>
                                        <p className="text-gray-600 dark:text-gray-300">
                                            Bulan {monthNames[currentMonth - 1]} {currentYear} tidak memiliki event khusus yang terjadwal.
                                        </p>
                                    </div>
                                )}
                            </div>
                        </div>
                    </div>
                </div>

                {/* Event Detail Modal */}
                {selectedEvent && (
                    <div className="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                        <div className="bg-white dark:bg-gray-800 rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                            <div className="p-6">
                                <div className="flex items-start justify-between mb-6">
                                    <div className="flex items-start space-x-3">
                                        <div className="text-4xl">{getEventIcon(selectedEvent.event_type)}</div>
                                        <div>
                                            <h2 className="text-2xl font-bold text-gray-900 dark:text-white">
                                                {selectedEvent.event_name}
                                            </h2>
                                            <p className="text-gray-600 dark:text-gray-300 mt-1">
                                                {formatDate(selectedEvent.event_date)}
                                            </p>
                                            <span className={`inline-block px-3 py-1 text-sm rounded-full mt-2 ${getEventTypeColor(selectedEvent.event_type)}`}>
                                                {getEventTypeLabel(selectedEvent.event_type)}
                                            </span>
                                        </div>
                                    </div>
                                    <Button
                                        onClick={() => setSelectedEvent(null)}
                                        variant="outline"
                                        size="sm"
                                    >
                                        ✕
                                    </Button>
                                </div>

                                <div className="space-y-6">
                                    <div>
                                        <h3 className="font-semibold text-gray-900 dark:text-white mb-2">
                                            📝 Deskripsi
                                        </h3>
                                        <p className="text-gray-600 dark:text-gray-300">
                                            {selectedEvent.description}
                                        </p>
                                    </div>

                                    <div>
                                        <h3 className="font-semibold text-gray-900 dark:text-white mb-3">
                                            💡 Ide Konten Lengkap
                                        </h3>
                                        <ul className="space-y-2">
                                            {selectedEvent.content_ideas.map((idea, index) => (
                                                <li key={index} className="flex items-start space-x-2">
                                                    <span className="text-blue-500 mt-1">•</span>
                                                    <span className="text-gray-700 dark:text-gray-300">
                                                        {idea}
                                                    </span>
                                                </li>
                                            ))}
                                        </ul>
                                    </div>

                                    {selectedEvent.hashtags && selectedEvent.hashtags.length > 0 && (
                                        <div>
                                            <h3 className="font-semibold text-gray-900 dark:text-white mb-3">
                                                🏷️ Hashtag untuk Social Media
                                            </h3>
                                            <div className="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                                                <p className="text-gray-700 dark:text-gray-300 font-mono text-sm">
                                                    {selectedEvent.hashtags.map(tag => `#${tag}`).join(' ')}
                                                </p>
                                            </div>
                                            <div className="flex flex-wrap gap-2 mt-3">
                                                {selectedEvent.hashtags.map((tag, index) => (
                                                    <span
                                                        key={index}
                                                        className="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded"
                                                    >
                                                        #{tag}
                                                    </span>
                                                ))}
                                            </div>
                                        </div>
                                    )}

                                    <div className="pt-4 border-t border-gray-200 dark:border-gray-600">
                                        <Link
                                            href={route('content.index')}
                                            className="block w-full text-center bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition-colors font-medium"
                                        >
                                            🚀 Buat Konten untuk Event Ini
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                )}
            </div>
        </>
    );
}