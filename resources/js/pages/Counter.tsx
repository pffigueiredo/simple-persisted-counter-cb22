import React from 'react';
import { AppShell } from '@/components/app-shell';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { router } from '@inertiajs/react';
import { Plus, Minus } from 'lucide-react';

interface Props {
    count: number;
    [key: string]: unknown;
}

export default function Counter({ count }: Props) {
    const handleIncrement = () => {
        router.post(route('counter.store'), 
            { action: 'increment' }, 
            {
                preserveState: true,
                preserveScroll: true
            }
        );
    };

    const handleDecrement = () => {
        router.post(route('counter.store'), 
            { action: 'decrement' }, 
            {
                preserveState: true,
                preserveScroll: true
            }
        );
    };

    return (
        <AppShell>
            <div className="min-h-screen bg-background flex items-center justify-center p-4">
                <Card className="w-full max-w-md">
                    <CardHeader className="text-center">
                        <CardTitle className="text-3xl font-bold">Counter App</CardTitle>
                        <CardDescription>
                            A persistent counter that remembers its value
                        </CardDescription>
                    </CardHeader>
                    <CardContent className="space-y-6">
                        <div className="text-center">
                            <div className="text-6xl font-bold text-primary mb-2">
                                {count}
                            </div>
                            <p className="text-muted-foreground">Current Count</p>
                        </div>
                        
                        <div className="flex gap-4 justify-center">
                            <Button
                                onClick={handleDecrement}
                                variant="outline"
                                size="lg"
                                className="flex-1 max-w-32"
                            >
                                <Minus className="w-5 h-5 mr-2" />
                                Decrement
                            </Button>
                            
                            <Button
                                onClick={handleIncrement}
                                size="lg"
                                className="flex-1 max-w-32"
                            >
                                <Plus className="w-5 h-5 mr-2" />
                                Increment
                            </Button>
                        </div>
                        
                        <div className="text-center text-sm text-muted-foreground">
                            This counter value is saved to the database and will persist 
                            even after you close and reopen your browser.
                        </div>
                    </CardContent>
                </Card>
            </div>
        </AppShell>
    );
}