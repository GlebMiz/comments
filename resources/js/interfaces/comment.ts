interface CommentFiles {
    type: 'file' | 'image';
    name: string;
    path: string;
}

export interface Comment {
    id?: string;
    name: string;
    email: string;
    date: string;
    text: string;
    files?: CommentFiles[];
    replies?: Comment[];
}