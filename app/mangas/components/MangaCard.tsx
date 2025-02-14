import { Manga } from "@/app/types/manga";
import { Card, CardActionArea, CardContent, CardMedia, Grid2, Typography } from "@mui/material";

interface MangaCardProps {
    manga: Manga
}

export default function MangaCard( { manga }: MangaCardProps ) {
    return (
        <Grid2 key={manga.id} size={{ xs: 12, sm: 4, md: 4, lg: 3 }}>
            <Card sx={{ maxWidth: 345 }}>
                <CardActionArea>
                    <CardMedia
                    component="img"
                    height="140"
                    image={`${manga.coverImageUrl}`}
                    alt="green iguana"
                    />
                    <CardContent>
                    <Typography gutterBottom variant="h5" component="div">
                        {manga.title}
                    </Typography>
                    <Typography variant="body2" sx={{ color: 'text.secondary' }}>
                        Lizards are a widespread group of squamate reptiles, with over 6,000
                        species, ranging across all continents except Antarctica
                    </Typography>
                    </CardContent>
                </CardActionArea>
            </Card>
        </Grid2>
    )
}
