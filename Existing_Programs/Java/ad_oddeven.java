import java.util.*;
class ad_oddeven
{
    public static void main(String args[]) 
    {
        Scanner sc = new Scanner(System.in);
        System.out.println("Enter size of array ");
        int size = sc.nextInt();
        int fix[] = new int[size];
        int odd[] = new int[size];
        int even[] = new int[size];
        int k=0,j=0;
        for (int i=0;i<size;i++) 
        {
            System.out.println("Enter value ");
            tns[i]=sc.nextInt();
        }
        System.out.println("Entered values ");
        for (int i=0;i<size;i++) 
        {
            System.out.print(tns[i]+ ", ");

            if (fix[i]%2==0) 
            {
		even[k++]=fix[i];
            }
             else 
            {
		odd[j++]=fix[i];
            }
        }
        System.out.println("even array =");
        for (int i=0; i<k; i++) 
        {
		System.out.print(even[i] + ", ");
        }
        System.out.println("odd Array = ");
        for (int i=0;i<j;i++) 
        {
            System.out.print(odd[i] + ", ");
        }
        for (int i=0;i<size;i++) 
        {
            for (int x = 0; x < size - i - 1; x++) 
            {
                if (fix[x] > fix[x + 1]) 
                {
                    int temp = fix[x];
                    fix[x] = fix[x + 1];
                    fix[x + 1] = temp;
                }
            }
        }
        System.out.println("Sorted array =");
        for (int i=0;i<size;i++) 
        {
            System.out.print(tns[i] + ", ");
        }
    }
}
