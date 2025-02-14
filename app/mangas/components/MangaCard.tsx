import useMangaStore from "@/app/store/mangaStore";
import { Manga } from "@/app/types/manga";
import { Card, CardActionArea, CardContent, CardMedia, Grid2, Typography } from "@mui/material";
import { useRouter } from "next/navigation";
import { Fade } from "react-awesome-reveal"

interface MangaCardProps {
    manga: Manga
}

export default function MangaCard( { manga }: MangaCardProps ) {

    const { setManga } = useMangaStore()
    const router = useRouter()

    const goToDetials = (id: string) => {
        setManga(manga) 
        router.push(`/mangas/${id}`)
    }

    return (
        <Grid2 key={manga.id} size={{ xs: 12, sm: 4, md: 4, lg: 3 }}>
            <Fade>
            <Card
            onClick={() => goToDetials(manga.id)} 
            sx={{ maxWidth: 345 }}
            >
                <CardActionArea>
                    <CardMedia
                    component="img"
                    image={`${manga.coverImageUrl}`}
                    alt="green iguana"
                    sx={{
                        maxHeight: 380,
                    }}
                    className="antialiased"
                    />
                    <CardContent
                    sx={{
                        height: 130
                    }}
                    >
                    <Typography gutterBottom variant="h5" component="div">
                        {manga.title}
                    </Typography>
                    <Typography variant="body2" sx={{ color: 'text.secondary' }}>
                        {manga.purchasedVolumes}/{manga.totalVolumes}
                    </Typography>
                    </CardContent>
                </CardActionArea>
            </Card>
            </Fade>
        </Grid2>
    )
}
